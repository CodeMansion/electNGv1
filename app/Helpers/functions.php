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
                    \DB::table('wards')->truncate();
                    foreach ($data as $key => $value) {
                        \DB::table("wards")->insert([
                            'state_id' => $value->state_id, 
                            'constituency_id' => $value->constituency_id,
                            'lga_id' => $value->lga_id,
                            'slug' => bin2hex(random_bytes(64)),
                            'name' => $value->name
                        ]);
                    }
                } 
                if($query == 'update'){
                    foreach ($data as $key => $value) {
                        \DB::table("wards")->insert([
                            'state_id' => $value->state_id, 
                            'constituency_id' => $value->constituency_id,
                            'lga_id' => $value->lga_id,
                            'slug' => bin2hex(random_bytes(64)),
                            'name' => $value->name
                        ]);
                    }
                } 
            }
        }

        //bulk upload for constituency
        if($type == "constituency") {
            if($data->count()){
                if($query == 'override'){
                    \DB::table('constituencies')->truncate();
                    foreach ($data as $key => $value) {
                        \DB::table("constituencies")->insert([
                            'state_id' => $value->state_id, 
                            'slug' => bin2hex(random_bytes(64)),
                            'name' => $value->name
                        ]);
                    }
                } else {
                    foreach ($data as $key => $value) {
                        \DB::table("constituencies")->insert([
                            'state_id' => $value->state_id, 
                            'slug' => bin2hex(random_bytes(64)),
                            'name' => $value->name
                        ]);
                    }
                }
            }
        }

         //bulk upload for polling centres
         if($type == 'polling-centres') {
            if($data->count()){
                if($query == 'override'){
                    \DB::table('polling_stations')->truncate();
                    foreach ($data as $key => $value) {
                        \DB::table("polling_stations")->insert([
                            'slug' => bin2hex(random_bytes(64)),
                            'state_id' => $value->state_id,
                            'constituency_id' => $value->constituency_id,
                            'lga_id' => $value->lga_id,
                            'ward_id' => $value->ward_id,
                            'name' => $value->name
                        ]);
                    }
                } else {
                    foreach ($data as $key => $value) {
                        \DB::table("polling_stations")->insert([
                            'slug' => bin2hex(random_bytes(64)),
                            'state_id' => $value->state_id,
                            'constituency_id' => $value->constituency_id,
                            'lga_id' => $value->lga_id,
                            'ward_id' => $value->ward_id,
                            'name' => $value->name
                        ]);
                    }
                }
            }
        }

        //bulk upload for polling centres
        if($type == 'lga') {
            if($data->count()){
                if($query == 'override'){
                    \DB::table('lgas')->truncate();
                    foreach ($data as $key => $value) {
                        \DB::table('lgas')->insert([
                            'state_id' => $value->state_id, 
                            'constituency_id' => $value->constituency_id,
                            'name' => $value->name
                        ]);
                    }
                } else {
                    foreach ($data as $key => $value) {
                        \DB::table('lgas')->insert([
                            'state_id' => $value->state_id, 
                            'constituency_id' => $value->constituency_id,
                            'name' => $value->name
                        ]);
                    }
                }
            }
        }
    }
}

function displayCharts($name=null,$level=null,$election=null,$state_id=null,$const_id=null,$lga_id=null,$ward_id=null,$unit_id=null)
{
        if($name == 'pie'){
            if($level == 'general'){
                $data = []; $value = [];$count = 0;$new = [];
                $result = $election->get_result_summary('general');
                foreach($result as $key => $v){
                    $data[$count] = $key;
                    $value[$count] = $v;
                    $count++;
                }
                array_values($data);array_values($value);
                $pieChart = \Charts::create('pie','highcharts')->title('Showing Result With Pie Chart')->labels($data)->values($value)->responsive(false);
    
                return $pieChart;
            }

            if($level == 'state'){
                $data = []; $value = [];$count = 0;$new = [];
                $result = $election->get_result_summary('state',$state_id);
                foreach($result as $key => $v){
                    $data[$count] = $key;
                    $value[$count] = $v;
                    $count++;
                }
                array_values($data);array_values($value);
                $pieChart = \Charts::create('pie','highcharts')->title('Showing Result With Pie Chart')->labels($data)->values($value)->responsive(false);
    
                return $pieChart;
            }

            if($level == 'constituency'){
                $data = []; $value = [];$count = 0;$new = [];
                $result = $election->get_result_summary('constituency',$state_id,$const_id);
                foreach($result as $key => $v){
                    $data[$count] = $key;
                    $value[$count] = $v;
                    $count++;
                }
                array_values($data);array_values($value);
                $pieChart = \Charts::create('pie','highcharts')->title('Showing Result With Pie Chart')->labels($data)->values($value)->responsive(false);
    
                return $pieChart;
            }

            if($level == 'local'){
                $data = []; $value = [];$count = 0;$new = [];
                $result = $election->get_result_summary('local',$state_id,$const_id,$lga_id);
                foreach($result as $key => $v){
                    $data[$count] = $key;
                    $value[$count] = $v;
                    $count++;
                }
                array_values($data);array_values($value);
                $pieChart = \Charts::create('pie','highcharts')->title('Showing Result With Pie Chart')->labels($data)->values($value)->responsive(false);
    
                return $pieChart;
            }

            if($level == 'ward'){
                $data = []; $value = [];$count = 0;$new = [];
                $result = $election->get_result_summary('ward',$state_id,$const_id,$lga_id,$ward_id);
                foreach($result as $key => $v){
                    $data[$count] = $key;
                    $value[$count] = $v;
                    $count++;
                }
                array_values($data);array_values($value);
                $pieChart = \Charts::create('pie','highcharts')->title('Showing Result With Pie Chart')->labels($data)->values($value)->responsive(false);
    
                return $pieChart;
            }

            if($level == 'stations'){
                $data = []; $value = [];$count = 0;$new = [];
                $result = $election->get_result_summary('polling-station',$state_id,$lga_id,$ward_id,$unit_id);
                foreach($result as $key => $v){
                    $data[$count] = $key;
                    $value[$count] = $v;
                    $count++;
                }
                array_values($data);array_values($value);
                $pieChart = \Charts::create('pie','highcharts')->title('Showing Result With Pie Chart')->labels($data)->values($value)->responsive(false);
    
                return $pieChart;
            }
        }

        //displaying charts result for barchart
        if($name == 'bar'){
            if($level == 'general'){
                $data = []; $value = [];$count = 0;$new = [];
                $result = $election->get_result_summary('general');
                foreach($result as $key => $v){
                    $data[$count] = $key;
                    $value[$count] = $v;
                    $count++;
                }
                array_values($data);array_values($value);
                $barChart = \Charts::create('bar', 'highcharts')->title('Showing Result With Bar Chart')->labels($data)->values($value)->responsive(false);
                
                return $barChart;
            }

            if($level == 'state'){
                $data = []; $value = [];$count = 0;$new = [];
                $result = $election->get_result_summary('state',$state_id);
                foreach($result as $key => $v){
                    $data[$count] = $key;
                    $value[$count] = $v;
                    $count++;
                }
                array_values($data);array_values($value);
                $barChart = \Charts::create('bar', 'highcharts')->title('Showing Result With Bar Chart')->labels($data)->values($value)->responsive(false);
                
                return $barChart;
            }

            if($level == 'constituency'){
                $data = []; $value = [];$count = 0;$new = [];
                $result = $election->get_result_summary('constituency',$state_id,$const_id);
                foreach($result as $key => $v){
                    $data[$count] = $key;
                    $value[$count] = $v;
                    $count++;
                }
                array_values($data);array_values($value);
                $barChart = \Charts::create('bar', 'highcharts')->title('Showing Result With Bar Chart')->labels($data)->values($value)->responsive(false);
                
                return $barChart;
            }

            if($level == 'local'){
                $data = []; $value = [];$count = 0;$new = [];
                $result = $election->get_result_summary('local',$state_id,$const_id,$lga_id);
                foreach($result as $key => $v){
                    $data[$count] = $key;
                    $value[$count] = $v;
                    $count++;
                }
                array_values($data);array_values($value);
                $barChart = \Charts::create('bar', 'highcharts')->title('Showing Result With Bar Chart')->labels($data)->values($value)->responsive(false);
                
                return $barChart;
            }

            if($level == 'ward'){
                $data = []; $value = [];$count = 0;$new = [];
                $result = $election->get_result_summary('ward',$state_id,$const_id,$lga_id,$ward_id);
                foreach($result as $key => $v){
                    $data[$count] = $key;
                    $value[$count] = $v;
                    $count++;
                }
                array_values($data);array_values($value);
                $barChart = \Charts::create('bar', 'highcharts')->title('Showing Result With Bar Chart')->labels($data)->values($value)->responsive(false);
                
                return $barChart;
            }

            if($level == 'stations'){
                $data = []; $value = [];$count = 0;$new = [];
                $result = $election->get_result_summary('polling-station',$state_id,$lga_id,$ward_id,$unit_id);
                foreach($result as $key => $v){
                    $data[$count] = $key;
                    $value[$count] = $v;
                    $count++;
                }
                array_values($data);array_values($value);
                $barChart = \Charts::create('bar', 'highcharts')->title('Showing Result With Bar Chart')->labels($data)->values($value)->responsive(false);
                
                return $barChart;
            }
        }
        
        if($name == 'donut') {
            if($level == 'general'){
                $data = []; $value = [];$count = 0;$new = [];
                $result = $election->get_result_summary('general');
                foreach($result as $key => $v){
                    $data[$count] = $key;
                    $value[$count] = $v;
                    $count++;
                }
                array_values($data);array_values($value);
                $donutChart = \Charts::create('donut', 'highcharts')->title('Showing Result With Donut Chart')->labels($data)->values($value)->responsive(false);
                
                return $donutChart;
            }

            if($level == 'state'){
                $data = []; $value = [];$count = 0;$new = [];
                $result = $election->get_result_summary('state',$state_id);
                foreach($result as $key => $v){
                    $data[$count] = $key;
                    $value[$count] = $v;
                    $count++;
                }
                array_values($data);array_values($value);
                $donutChart = \Charts::create('donut', 'highcharts')->title('Showing Result With Donut Chart')->labels($data)->values($value)->responsive(false);
                
                return $donutChart;
            }

            if($level == 'constituency'){
                $data = []; $value = [];$count = 0;$new = [];
                $result = $election->get_result_summary('constituency',$state_id,$const_id);
                foreach($result as $key => $v){
                    $data[$count] = $key;
                    $value[$count] = $v;
                    $count++;
                }
                array_values($data);array_values($value);
                $donutChart = \Charts::create('donut', 'highcharts')->title('Showing Result With Donut Chart')->labels($data)->values($value)->responsive(false);
                
                return $donutChart;
            }

            if($level == 'local'){
                $data = []; $value = [];$count = 0;$new = [];
                $result = $election->get_result_summary('local',$state_id,$const_id,$lga_id);
                foreach($result as $key => $v){
                    $data[$count] = $key;
                    $value[$count] = $v;
                    $count++;
                }
                array_values($data);array_values($value);
                $donutChart = \Charts::create('donut', 'highcharts')->title('Showing Result With Donut Chart')->labels($data)->values($value)->responsive(false);
                
                return $donutChart;
            }

            if($level == 'ward'){
                $data = []; $value = [];$count = 0;$new = [];
                $result = $election->get_result_summary('ward',$state_id,$const_id,$lga_id,$ward_id);
                foreach($result as $key => $v){
                    $data[$count] = $key;
                    $value[$count] = $v;
                    $count++;
                }
                array_values($data);array_values($value);
                $donutChart = \Charts::create('donut', 'highcharts')->title('Showing Result With Donut Chart')->labels($data)->values($value)->responsive(false);
                
                return $donutChart;
            }

            if($level == 'stations'){
                $data = []; $value = [];$count = 0;$new = [];
                $result = $election->get_result_summary('polling-station',$state_id,$lga_id,$ward_id,$unit_id);
                foreach($result as $key => $v){
                    $data[$count] = $key;
                    $value[$count] = $v;
                    $count++;
                }
                array_values($data);array_values($value);
                $donutChart = \Charts::create('donut', 'highcharts')->title('Showing Result With Donut Chart')->labels($data)->values($value)->responsive(false);
                
                return $donutChart;
            }
        }

        if($name == 'area') {
            if($level == 'general'){
                $data = []; $value = [];$count = 0;$new = [];
                $result = $election->get_result_summary('general');
                foreach($result as $key => $v){
                    $data[$count] = $key;
                    $value[$count] = $v;
                    $count++;
                }
                array_values($data);array_values($value);
                $areaChart = \Charts::create('area', 'highcharts')->title('Showing Result With Area Chart')->labels($data)->values($value)->responsive(false);
                
                return $areaChart;
            }
            if($level == 'state'){
                $data = []; $value = [];$count = 0;$new = [];
                $result = $election->get_result_summary('state',$state_id);
                foreach($result as $key => $v){
                    $data[$count] = $key;
                    $value[$count] = $v;
                    $count++;
                }
                array_values($data);array_values($value);
                $areaChart = \Charts::create('area', 'highcharts')->title('Showing Result With Area Chart')->labels($data)->values($value)->responsive(false);
                
                return $areaChart;
            }

            if($level == 'constituency'){
                $data = []; $value = [];$count = 0;$new = [];
                $result = $election->get_result_summary('constituency',$state_id,$const_id);
                foreach($result as $key => $v){
                    $data[$count] = $key;
                    $value[$count] = $v;
                    $count++;
                }
                array_values($data);array_values($value);
                $areaChart = \Charts::create('area', 'highcharts')->title('Showing Result With Area Chart')->labels($data)->values($value)->responsive(false);
                
                return $areaChart;
            }

            if($level == 'local'){
                $data = []; $value = [];$count = 0;$new = [];
                $result = $election->get_result_summary('local',$state_id,$const_id,$lga_id);
                foreach($result as $key => $v){
                    $data[$count] = $key;
                    $value[$count] = $v;
                    $count++;
                }
                array_values($data);array_values($value);
                $areaChart = \Charts::create('area', 'highcharts')->title('Showing Result With Area Chart')->labels($data)->values($value)->responsive(false);
                
                return $areaChart;
            }

            if($level == 'ward'){
                $data = []; $value = [];$count = 0;$new = [];
                $result = $election->get_result_summary('ward',$state_id,$const_id,$lga_id,$ward_id);
                foreach($result as $key => $v){
                    $data[$count] = $key;
                    $value[$count] = $v;
                    $count++;
                }
                array_values($data);array_values($value);
                $areaChart = \Charts::create('area', 'highcharts')->title('Showing Result With Area Chart')->labels($data)->values($value)->responsive(false);
                
                return $areaChart;
            }

            if($level == 'stations'){
                $data = []; $value = [];$count = 0;$new = [];
                $result = $election->get_result_summary('polling-station',$state_id,$lga_id,$ward_id,$unit_id);
                foreach($result as $key => $v){
                    $data[$count] = $key;
                    $value[$count] = $v;
                    $count++;
                }
                array_values($data);array_values($value);
                $areaChart = \Charts::create('area', 'highcharts')->title('Showing Result With Area Chart')->labels($data)->values($value)->responsive(false);
                
                return $areaChart;
            }
        }
    }