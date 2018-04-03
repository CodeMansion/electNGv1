<?php 

use Illuminate\Database\Schema\Blueprint;

function centre($id){
    $centre = \App\PollingStation::find($id);
    return strtoupper($centre['name']);
}

function lga($id){
    $lga = \App\Lga::find($id);
    return strtoupper($lga['name']);
}

function ward($id){
    $ward = \App\Ward::find($id);
    return strtoupper($ward['name']);
}

function state($id){
    $state = \App\State::find($id);
    return strtoupper($state['name']);
}

function constituency($id){
    $state = \App\Constituency::find($id);
    return strtoupper($state['name']);
}

function party_code($id) {
    $party = \App\PoliticalParty::find($id);
    $code = $party['code'];

    return $code;
}

function convertImgToBase64($filename){
    $type = pathinfo($filename, PATHINFO_EXTENSION);
    $data = file_get_contents($filename);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    return $base64;
}

function UploadPartyLogo($file,$data){
    if($file){
        //image is alredy existing with the same product id
        $file_ext = $file->getClientOriginalExtension();
        $file_ext = "png";
        $file_name = $data .'.'. $file_ext;
        $path = storage_path('/uploads/parties-logos/') . $file_name;
        Image::make($file)->resize(80,80)->save($path);
        return $path;
    } 
}

function activity_logs($user=null,$ip,$action,$type,$location=null) {
    if($type == 'api') {
        $log = new App\ActivityLog();
		$log->slug = bin2hex(random_bytes(64));
        $log->user_id = null;
        $log->location = $location;
		$log->ip_address = $ip;
		$log->action = $action;
		$log->save();
    }
    if($type == 'app') {
        if(isset($user) && isset($ip) && isset($action)) {
            $log = new App\ActivityLog();
            $log->slug = bin2hex(random_bytes(64));
            $log->user_id = $user;
            $log->ip_address = $ip;
            $log->action = $action;
            $log->save();
        }
    }
}


function bulkUpload($type,$query,$file)
{
    if(isset($file)){
        $path = $file->getRealPath();
        $data = \Excel::load($path)->get();
        
        //bulk upload wards under local govt
        if($type == 'ward') {
            if($data->count()){
                if($query == 'override'){
                    \DB::statement('SET FOREIGN_KEY_CHECKS = 0');
                    \DB::table('wards')->truncate();
                    foreach ($data as $key => $value) {
                        \DB::table("wards")->insert([
                            'state_id'          => $value->state_id, 
                            'constituency_id'   => $value->constituency_id,
                            'lga_id'            => $value->lga_id,
                            'slug'              => bin2hex(random_bytes(64)),
                            'name'              => $value->name
                        ]);
                    }
                } 

                if($query == 'update'){
                    foreach ($data as $key => $value) {
                        \DB::table("wards")->insert([
                            'state_id'          => $value->state_id, 
                            'constituency_id'   => $value->constituency_id,
                            'lga_id'            => $value->lga_id,
                            'slug'              => bin2hex(random_bytes(64)),
                            'name'              => $value->name
                        ]);
                    }
                } 
            }
        }

        //bulk upload for constituency
        if($type == "constituency") {
            if($data->count()){
                if($query == 'override'){
                    \DB::statement('SET FOREIGN_KEY_CHECKS = 0');
                    \DB::table('constituencies')->truncate();
                    foreach ($data as $key => $value) {
                        \DB::table("constituencies")->insert([
                            'state_id'  => $value->state_id, 
                            'slug'      => bin2hex(random_bytes(64)),
                            'name'      => $value->name
                        ]);
                    }
                } else {
                    foreach ($data as $key => $value) {
                        \DB::table("constituencies")->insert([
                            'state_id'  => $value->state_id, 
                            'slug'      => bin2hex(random_bytes(64)),
                            'name'      => $value->name
                        ]);
                    }
                }
            }
        }

         //bulk upload for polling centres
         if($type == 'polling-centres') {
            if($data->count()){
                if($query == 'override'){
                    \DB::statement('SET FOREIGN_KEY_CHECKS = 0');
                    \DB::table('polling_stations')->truncate();
                    foreach ($data as $key => $value) {
                        \DB::table("polling_stations")->insert([
                            'slug'              => bin2hex(random_bytes(64)),
                            'state_id'          => $value->state_id,
                            'constituency_id'   => $value->constituency_id,
                            'lga_id'            => $value->lga_id,
                            'ward_id'           => $value->ward_id,
                            'name'              => $value->name
                        ]);
                    }
                } else {
                    foreach ($data as $key => $value) {
                        \DB::table("polling_stations")->insert([
                            'slug'              => bin2hex(random_bytes(64)),
                            'state_id'          => $value->state_id,
                            'constituency_id'   => $value->constituency_id,
                            'lga_id'            => $value->lga_id,
                            'ward_id'           => $value->ward_id,
                            'name'              => $value->name
                        ]);
                    }
                }
            }
        }

        //bulk upload for polling centres
        if($type == 'lga') {
            if($data->count()){
                if($query == 'override'){
                    \DB::statement('SET FOREIGN_KEY_CHECKS = 0');
                    \DB::table('lgas')->truncate();
                    foreach ($data as $key => $value) {
                        \DB::table('lgas')->insert([
                            'state_id'          => $value->state_id, 
                            'constituency_id'   => $value->constituency_id,
                            'name'              => $value->name
                        ]);
                    }
                } else {
                    foreach ($data as $key => $value) {
                        \DB::table('lgas')->insert([
                            'state_id'          => $value->state_id, 
                            'constituency_id'   => $value->constituency_id,
                            'name'              => $value->name
                        ]);
                    }
                }
            }
        }
    }
}

function ChartDisplay($election,$type) {
    $Ret = [];
    $codes = []; 
    $votes = [];
    $count = 0;
    $new = [];

    $result = $election->getResult('general');
    $parties = $election->parties()->get();
    foreach($parties as $i => $party) {
        $code = $party['code'];
        $Ret[$i] = 0;
    }

    foreach($parties as $i => $party) {
        $codes[$i] = $party['code'];
        foreach($result as $key => $val){
            if($val['party_code'] == $party['code']) {
                $Ret[$i] += (int)$val['votes'];
            }
        }
    }

    array_values($Ret);
    array_values($codes);

    if($type == 'bar') {
        $chart = \Charts::create('bar', 'highcharts')->title($election['name'])->labels($codes)->values($Ret)->responsive(false);
    }

    if($type == 'pie') {
        $chart = \Charts::create('pie', 'highcharts')->title($election['name'])->labels($codes)->values($Ret)->responsive(false);
    }

    if($type == 'donut') {
        $chart = \Charts::create('donut', 'highcharts')->title($election['name'])->labels($codes)->values($Ret)->responsive(false);
    }

    if($type == 'line') {
        $chart = \Charts::create('line', 'highcharts')->title($election['name'])->labels($codes)->values($Ret)->responsive(false);
    }
    
    return $chart;
}