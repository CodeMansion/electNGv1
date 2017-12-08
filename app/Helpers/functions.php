<?php 

function bulkUpload($type,$file=null)
{
    if(isset($file)){
        $path = $file->getRealPath();
        $data = \Excel::load($path)->get();
        
        //bulk upload wards under local govt
        if($type == 'ward') {
            if($data->count()){
                foreach ($data as $key => $value) {
                    $arr[] = [
                        'state_id' => $value->state_id, 
                        'lga_id' => $value->lga_id,
                        'slug' => bin2hex(random_bytes(64)),
                        'name' => $value->name,
                        'code' => $value->code
                    ];
                }
                if(!empty($arr)){
                    \DB::table('wards')->insert($arr);
                    return true;
                }
            }
        }

         //bulk upload for polling centres
         if($type == 'polling-centres') {
            if($data->count()){
                foreach ($data as $key => $value) {
                    $arr[] = [
                        'state_id' => $value->state_id, 
                        'lga_id' => $value->lga_id,
                        'ward_id' => $value->ward_id,
                        'slug' => bin2hex(random_bytes(64)),
                        'name' => $value->name,
                        'code' => $value->code
                    ];
                }
                if(!empty($arr)){
                    \DB::table('polling_stations')->insert($arr);
                    return true;
                }
            }
        }

        //bulk upload for polling centres
        if($type == 'lga') {
            if($data->count()){
                foreach ($data as $key => $value) {
                    $arr[] = [
                        'state_id' => $value->state_id, 
                        'name' => $value->name,
                        'slug' => bin2hex(random_bytes(64))
                    ];
                }
                if(!empty($arr)){
                    \DB::table('lgas')->insert($arr);
                    return true;
                }
            }
        }
    }

    //display charts function
    
}