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

function bulkUpload($type,$file=null)
{
    if(isset($file)){
        $path = $file->getRealPath();
        $data = \Excel::load($path)->get();
        
        //bulk upload wards under local govt
        if($type == 'ward') {
            if($data->count()){
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
                if(!empty($arr)){
                    return true;
                }
            }
        }


        if($type == "constituency") {
            if($data->count()){
                \DB::table('constituencies')->truncate();
                foreach ($data as $key => $value) {
                    $arr[] = [
                        'state_id' => $value->state_id, 
                        'slug' => bin2hex(random_bytes(64)),
                        'name' => $value->name
                    ];
                }
                if(!empty($arr)){
                    \DB::table('constituencies')->insert($arr);
                    return true;
                }
            }
        }

         //bulk upload for polling centres
         if($type == 'polling-centres') {
            if($data->count()){
                \DB::table('polling_stations')->truncate();
                foreach ($data as $key => $value) {
                    \DB::table('polling_stations')->insert([
                        'slug' => bin2hex(random_bytes(64)),
                        'state_id' => $value->state_id, 
                        'constituency_id' => $value->constituency_id,
                        'lga_id' => $value->lga_id,
                        'ward_id' => $value->ward_id,
                        'name' => $value->name
                    ]);
                }
                if(!empty($arr)){
                    return true;
                }
            }
        }

        //bulk upload for polling centres
        if($type == 'lga') {
            if($data->count()){
                \DB::table('lgas')->truncate();
                foreach ($data as $key => $value) {
                    $arr[] = [
                        'state_id' => $value->state_id, 
                        'constituency_id' => $value->constituency_id,
                        'name' => $value->name
                    ];
                }
                if(!empty($arr)){
                    \DB::table('lgas')->insert($arr);
                    return true;
                }
            }
        }
    }
}

function displayCharts($name=null,$level=null,$election=null,$state_id=null,$const_id=null,$lga_id=null,$ward_id=null,$unit_id=null)
{
        if($name == 'pie'){
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
            if($level == 'state'){
                $data = []; $value = [];$count = 0;$new = [];
                $result = $election->get_result_summary('state',$state_id);
                foreach($result as $key => $v){
                    $data[$count] = $key;
                    $value[$count] = $v;
                    $count++;
                }
                array_values($data);array_values($value);
                $areaChart = \Charts::create('area', 'highcharts')->title('Showing Result With Area Chart')->elementLabel('My nice label')->labels($data)->values($value)->responsive(false);
                
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
                $areaChart = \Charts::create('area', 'highcharts')->title('Showing Result With Area Chart')->elementLabel('My nice label')->labels($data)->values($value)->responsive(false);
                
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
                $areaChart = \Charts::create('area', 'highcharts')->title('Showing Result With Area Chart')->elementLabel('My nice label')->labels($data)->values($value)->responsive(false);
                
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
                $areaChart = \Charts::create('area', 'highcharts')->title('Showing Result With Area Chart')->elementLabel('My nice label')->labels($data)->values($value)->responsive(false);
                
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
                $areaChart = \Charts::create('area', 'highcharts')->title('Showing Result With Area Chart')->elementLabel('My nice label')->labels($data)->values($value)->responsive(false);
                
                return $areaChart;
            }
        }
    }