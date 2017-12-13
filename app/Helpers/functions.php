<?php 

use Illuminate\Database\Schema\Blueprint;

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
}

function electionTypes($type,$data)
{
    //storing datas
    $parties = $data['party'];	
    $ElectionCode = strtolower(str_random(4));
    $lgas = $data['lga_id'];

    switch ($type) {
        case 1:
           # code...
           break;
        
        case 2:
           # code...
           break;

        case 3:
           # code...
        break;

        //creating an election for local government level
        case 4:
            //creating a new election
            $election = new \App\Election();
            $election->name = $data['name'];
            $election->slug = bin2hex(random_bytes(64));
            $election->description = ($data['description']) ? $data['description'] : null;
            $election->start_date = date("y-m-d",strtotime($data['start_date']));
            $election->end_date = date("y-m-d",strtotime($data['end_date']));
            $election->election_status_id = 1;
            $election->election_type_id = $data['type'];
            $election->save();
            
            //creating election parties
            foreach($parties as $key=>$v){
                \DB::table("pivot_election_party")->insert([
                    'state_id' => config('constants.ACTIVE_STATE_ID'),
                    'election_id' => $election->id,
                    'political_party_id' => $v,
                ]);
            }		

            // Create a new entry in the assessments index
            \App\ElectionResultIndex::insert([
               "election_id"=>$election->id, 
               "state_id"=>config('constants.ACTIVE_STATE_ID'),
               "election_code"=>$ElectionCode
            ]);

           //creating election polling units
            foreach($lgas as $key=>$l){
               $C = \App\PollingStation::where('state_id','=',config('constants.ACTIVE_STATE_ID'))->where('lga_id','=',$l)->get();
               //looping through each polling units under a local govt area
               foreach($C as $c){
                   \DB::table("pivot_election_polling_units")->insert([
                       'election_id' => $election->id,
                       'state_id' => config('constants.ACTIVE_STATE_ID'),
                       'lga_id' => $l,
                       'ward_id' => $c->ward_id,
                       'polling_station_id' => $c->id,
                       'status' => 1
                   ]);
               }
            }

            //creating a new table for election results
            \Schema::create("polling_result_$ElectionCode", function (Blueprint $table) use ($parties) {
                $table->increments('id');
                $table->integer('election_id')->unsigned()->index();
                $table->integer('constituency_id')->unsigned()->index()->nullable();
                $table->integer('state_id')->unsigned()->index();
                $table->integer('lga_id')->unsigned()->index();
                $table->integer('ward_id')->unsigned()->index();
                $table->integer('polling_station_id')->unsigned()->index();
                $table->integer('user_id')->unsigned()->index()->nullable();
                $table->integer('accr_voters')->nullable();
                $table->integer('void_voters')->nullable();
                $table->integer('status');
                $table->integer('confirmed_voters')->nullable();
               
                // create columns based on the number of parties
                foreach($parties as $key=>$v){
                    $party_code = \App\PoliticalParty::find($v);
                    $p = strtolower($party_code['code']);
                    $table->string($p);
                }
                $table->timestamps();
            });

            // Populate the table with the definition
            $insertData = [];
            foreach($lgas as $key=>$l){
                $C = \App\PollingStation::where('state_id','=',config('constants.ACTIVE_STATE_ID'))->where('lga_id','=',$l)->get();
                foreach($C as $c){
                    $insertData = [
                        "election_id"=>$election->id,
                        "state_id"=>config('constants.ACTIVE_STATE_ID'),
                        "lga_id"=>$l,
                        "ward_id"=>$c->ward_id,
                        "polling_station_id"=>$c->id,
                        "user_id"=>null,
                        "accr_voters"=>0,
                        "void_voters"=>0,
                        "status"=>1,
                        "confirmed_voters"=>0
                    ];
                    foreach($parties as $key=>$v){
                        $party_code = \App\PoliticalParty::find($v);
                        $p = strtolower($party_code['code']);
                        $insertData[$p] = 0;
                    }

                    \DB::table("polling_result_$ElectionCode")->insert($insertData);
                }
            }

            //creating api token access for this election
            $token = new \App\ElectionOnetimePassword();
            $token->election_id = $election->id;
            $token->otp = rand(111111,999999);
            $token->api_token = str_random(60);
            $token->save();

            return true;
        break;

        default:
           return false;
        break;
   }
}