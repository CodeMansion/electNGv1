<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;

use App\Election;
use App\PoliticalParty;
use App\State;
use App\Lga;
use App\PollingStation;
use App\ElectionResultIndex;
use App\User;

class ElectionController extends Controller
{
    public function index()
    {
        $data['elections'] = Election::all();
        $data['states'] = State::all();
        $data['politicalParties'] = PoliticalParty::orderBy('code','ASC')->get();

        return view('admin.election.index')->with($data);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        
        //Avoiding saving users with the same email addresses
        if(Election::isElectionExists($data['name']) == true){
            return false;
        }

        \DB::beginTransaction();
        try {
            //creating for local selected
            if($data['type'] == 'lga') {
                //storing datas
                $lgas = $data['lga_id'];
                $parties = $request->get('party');
                $ElectionCode = strtolower(str_random(4));

                //creating a new election
                $election = new Election();
                $election->name = $data['name'];
                $election->slug = bin2hex(random_bytes(64));
                $election->description = ($data['description']) ? $data['description'] : null;
                $election->start_date = date("y-m-d",strtotime($data['start_date']));
                $election->end_date = date("y-m-d",strtotime($data['end_date']));
                $election->election_status_id = 1;
                $election->save();

                // Create a new entry in the assessments index
		        ElectionResultIndex::insert([
                    "election_id"=>$election->id, 
                    "state_id"=>config('constants.ACTIVE_STATE_ID'),
                    "election_code"=>$ElectionCode
                ]);

                //creating election parties
                foreach($parties as $key=>$v){
                    \DB::table("pivot_election_party")->insert([
                        'state_id' => config('constants.ACTIVE_STATE_ID'),
                        'election_id' => $election->id,
                        'political_party_id' => $v,
                    ]);
                }

                //creating election polling units
                foreach($lgas as $key=>$l){
                    $C = PollingStation::where('state_id','=',config('constants.ACTIVE_STATE_ID'))->where('lga_id','=',$l)->get();
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
                \Schema::create("polling_result_$ElectionCode", function (Blueprint $table) use ($lgas, $parties){			
                    $table->increments('id');
                    $table->integer('election_id')->unsigned()->index();
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
                        $party_code = PoliticalParty::find($v);
                        $p = strtolower($party_code['code']);
                        $table->string($p);
                    }
                    $table->timestamps();
                });

                // Populate the table with the definition
                $insertData = [];
                foreach($lgas as $key=>$l){
                    $C = PollingStation::where('state_id','=',config('constants.ACTIVE_STATE_ID'))->where('lga_id','=',$l)->get();
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
                            $party_code = PoliticalParty::find($v);
                            $p = strtolower($party_code['code']);
                            $insertData[$p] = 0;
                        }

                        \DB::table("polling_result_$ElectionCode")->insert($insertData);
                    }
                }
                
                \DB::commit();
                return redirect()->back()->with("success","Election has been created successfully");
            }
        } catch(Exception $e) {
            \DB::rollback();
            return redirect()->back()->with("error","error occured");
        }
    }

    public function AjaxProcess(Request $request)
    {
        $data = $request->except('_token');

        if($data['req'] == 'viewLga') {
            $lga['lgas'] = Lga::where('state_id','=',config('constants.ACTIVE_STATE_ID'))->get();
            return view('admin.election.modals.partials._populate_lgas')->with($lga);
        }

        if($data['req'] == 'assignUsers') {
            \DB::beginTransaction();
            try {
                //assigning a user to polling unit in a state->local govt->ward
                //this will automatic replace user id because by default user_id field is set to null
                \DB::table("pivot_election_polling_units")
                        ->where('state_id','=',config('constants.ACTIVE_STATE_ID'))     
                        ->where('election_id','=',$data['election_id'])
                        ->where('lga_id','=',$data['lga_id'])
                        ->where('ward_id','=',$data['ward_id'])
                        ->where('polling_station_id','=',$data['polling_unit_id'])   
                        ->update([  
                            'user_id'=>$data['user_id'],
                        ]);
                
                //getting the current election result index code
                $IndexCode = ElectionResultIndex::where('state_id','=',config('constants.ACTIVE_STATE_ID'))
                                        ->where('election_id','=',$data['election_id'])
                                        ->first();
                $code = $IndexCode->election_code;
                
                //activating the user assigned to polling unit to be able to send election polling 
                //results of the polling station he/she is handling
                \DB::table("polling_result_$code")
                        ->where('state_id','=',config('constants.ACTIVE_STATE_ID'))
                        ->where('election_id','=',$data['election_id'])
                        ->where('lga_id','=',$data['lga_id'])
                        ->where('ward_id','=',$data['ward_id'])
                        ->where('polling_station_id','=',$data['polling_unit_id'])
                        ->update([
                            'user_id'=>$data['user_id']
                        ]);

                //generating the user access code that will validate a user when he/she is sending election result
                //and inserting it to
                $PassCode = strtoupper(str_random(6));
                \DB::table("pivot_election_users_passcode")->insert([
                    'election_id'=>$data['election_id'],
                    'state_id'=>config('constants.ACTIVE_STATE_ID'),
                    'lga_id'=>$data['lga_id'],
                    'ward_id'=>$data['ward_id'],
                    'polling_station_id'=>$data['polling_unit_id'],
                    'user_id'=>$data['user_id'],
                    'passcode'=>$PassCode,
                    'token'=>bin2hex(random_bytes(64))
                ]);

                //sending the passcode to user through email and text message


                \DB::commit();
                return "User has been assigned to polling centre successfully.";
                
            } catch(Exception $e) {
                \DB::rollback();
                return false;
            }
        }

        if($data['req'] == 'assignParty') {
            \DB::beginTransaction();
            try {
                $parties = $request->get('party');
    
                //Resetting class subjects to default
                $reset = \DB::table("pivot_election_party")
                                ->where('election_id','=',$data['election_id'])
                                ->where('state_id','=',1)
                                ->delete();
                
                //Assigning new parties to election
                foreach($parties as $value) {
                    \DB::table("pivot_election_party")->insert([
                        'state_id' => 1,
                        'election_id' => $data['election_id'],
                        'political_party_id' => $value,
                    ]);
                }
    
                \DB::commit();
                return "Parties successfully assigned to this election.";
    
            } catch(Exception $e) {
                \DB::rollback();
               return false;
            }
        }
    }

    public function changeStatus(Request $request){
        $data = $request->all();
        if($data['type'] == 'completed'){
            \DB::beginTransaction();
            try{
                $election = Election::find($data['election_id'],'slug');
                $election->election_status_id = 2;
                $election->save();

                \DB::commit();
                return redirect()->back()->with('success','Status changed successfully. Election is on the waiting mode.');

            } catch(Exception $e){
                \DB::rollback();
                return redirect()->back()->with('error','An error occured');
            }
        }

        if($data['type'] == 'begin'){
            \DB::beginTransaction();
            try{
                $election = Election::find($data['election_id'],'slug');
                $election->election_status_id = 3;
                $election->save();

                \DB::commit();
                return redirect()->back()->with('success','Status changed successfully. Election is now active.');

            } catch(Exception $e){
                \DB::rollback();
                return redirect()->back()->with('error','An error occured');
            }
        }

        if($data['type'] == 'end'){
            \DB::beginTransaction();
            try{
                $election = Election::find($data['election_id'],'slug');
                $election->election_status_id = 4;
                $election->save();

                \DB::commit();
                return redirect()->back()->with('success','Status changed successfully. Election ended.');

            } catch(Exception $e){
                \DB::rollback();
                return redirect()->back()->with('error','An error occured');
            }
        }
    }


    public function checkPasscode(Request $request){
        $data = $request->except('_token');

        if($data['req'] == 'checkCode'){
            $codeInfo = \DB::table("pivot_election_users_passcode")->where('passcode','=',$data['passcode'])->first();
            $param['user'] = User::find($codeInfo->user_id);
            $param['election'] = Election::find($codeInfo->election_id);
            //getting the the election index code
            $IndexCode = ElectionResultIndex::where('election_id','=',$codeInfo->election_id)
                                    ->where('state_id','=',$codeInfo->state_id)->first();
            $IC = $IndexCode['election_code'];
            //query the election result table
            $resultInfo = \DB::table("polling_result_$IC")
                            ->where('election_id','=',$codeInfo->election_id)
                            ->where('state_id','=',$codeInfo->state_id)
                            ->where('lga_id','=',$codeInfo->lga_id)
                            ->where('ward_id','=',$codeInfo->lga_id)
                            ->where('polling_station_id','=',$codeInfo->polling_station_id)
                            ->first();
            $param['resultInfo'] = $resultInfo;
            $param['electionParties'] = $param['election']->fnAssignParties()->get();
            $param['pollingResult'] = \DB::table("polling_result_$IC")
                            ->where('election_id','=',$codeInfo->election_id)
                            ->where('state_id','=',$codeInfo->state_id)
                            ->where('lga_id','=',$codeInfo->lga_id)
                            ->where('ward_id','=',$codeInfo->lga_id)
                            ->where('polling_station_id','=',$codeInfo->polling_station_id)
                            ->first();

            return view('admin.election.modals.partials._view_result_details')->with($param);
        }
    }

    //function for view a single election
    public function view($id)
    {
        $data['election'] = Election::find($id,'slug');
        $data['users'] = User::all();
        $data['electionParties'] = $data['election']->fnAssignParties()->get();
        $data['units'] = Election::find($id,'slug');
        $data['pollingUnits'] = $data['election']->fnPollingUnits()->get();
        $data['politicalParties'] = PoliticalParty::orderBy('code','ASC')->get();
        $data['pollingResults'] = $data['election']->get_polling_result()->get();
        $data['approvedPasscodes'] = $data['election']->fnApprovedPasscodes()->get();
        
        return view('admin.election.view-one')->with($data);
    }
}
