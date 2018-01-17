<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;

use App\Election;
use App\PoliticalParty;
use App\State;
use App\Lga;
use App\Ward;
use App\PollingStation;
use App\ElectionResultIndex;
use App\User;
use App\ElectionType;
use App\Constituency;
use App\ElectionOnetimePassword;
use App\PivotElectionReport;
use App\PivotElectionParty;

use App\Mail\SendPasscode;

use Charts;
use Mail;
use DB;
use Artisan;

class ElectionController extends Controller
{
    public function index()
    {
        $data['elections'] = Election::all();
        $data['states'] = State::all();
        $data['politicalParties'] = PoliticalParty::orderBy('code','ASC')->get();
        $data['electionTypes'] = ElectionType::all();

        return view('admin.election.index')->with($data);
    }

    public function store(Request $request)
    {   
        #TODO:: Processes for this function
        //1. 
        
        // $data = $request->except('_token');
        $data = $request->all();
        $parties = $data['party'];	
        $ElectionCode = strtolower(str_random(4));
        $state_id = $data['state_id'];
        $constituency_id = $data['constituency_id'];
        $lga = $data['lga_id'];

        //Avoiding saving users with the same email addresses
        if(Election::isElectionExists($data['name']) == true){
            return false;
        }

        \DB::beginTransaction();
        try {
            ini_set('max_execution_time', 0);
            $time_start = microtime(true);

            //creating a new election
            $election = \App\Election::insertGetId([
                'name' => $data['name'],
                'slug' => bin2hex(random_bytes(64)),
                'description' => ($data['description']) ? $data['description'] : null,
                'start_date' => date("y-m-d",strtotime($data['start_date'])),
                'end_date' => date("y-m-d",strtotime($data['end_date'])),
                'election_status_id' => 2,
                'election_type_id' => $data['type']
            ]);
           
            //creating election parties
            foreach($parties as $key=>$v){
                $p = DB::table("pivot_election_parties")->insert([
                    'election_id' => $election,
                    'political_party_id' => $v
                ]);
            }		
            
            if((int)$data['type'] == 1){//presidential election
                //creating election polling units
                
           
            } elseif((int)$data['type'] == 2) { //governshiop elections
                // Create a new entry in the assessments index
                DB::table("election_result_indices")->insert([
                    "election_id" =>$election, 
                    "election_code" => $ElectionCode
                ]);

                //creating election polling units
                $C = \App\PollingStation::where('state_id','=',$state_id)->get();
            
            } elseif((int)$data['type'] == 3) {//senetorial election
                // Create a new entry in the assessments index
                DB::table("election_result_indices")->insert([
                    "election_id" =>$election, 
                    "election_code" => $ElectionCode
                ]);

                //creating election polling units
                $C = \App\PollingStation::where('state_id','=',$state_id)->where('constituency_id','=',$constituency_id)->get();
            
            } elseif((int)$data['type'] == 4) {//local government election 
                // Create a new entry in the assessments index
                DB::table("election_result_indices")->insert([
                    "election_id" =>$election, 
                    "election_code" => $ElectionCode
                ]);
                
                if($lga >= 1){
                    //creating election polling units
                    $C = \App\PollingStation::where('state_id','=',$state_id)
                    ->where('constituency_id','=',$constituency_id)
                    ->where('lga_id','=',$lga)->get();
                } else {
                    \DB::rollback();
                    return redirect()->back()->with("error","Unable to get local government. Try again or contact system admin.");
                }
            }

            //looping through each polling units under a local govt area
            foreach($C as $c){
                \DB::table("pivot_election_polling_units")->insert([
                    'election_id' => $election,
                    'state_id' => $state_id,
                    'constituency_id' => $constituency_id,
                    'lga_id' => $c->lga_id,
                    'ward_id' => $c->ward_id,
                    'polling_unit_id' => $c->id,
                    'status' => 1
                ]);
            }

            //creating a new table for election results
            \Schema::create("polling_".$ElectionCode."_results", function (Blueprint $table) use ($parties) {
                $table->increments('id');
                $table->integer('election_id')->unsigned()->index();
                $table->integer('state_id')->unsigned()->index();
                $table->integer('constituency_id')->unsigned()->index()->nullable();
                $table->integer('lga_id')->unsigned()->index();
                $table->integer('ward_id')->unsigned()->index();
                $table->integer('polling_station_id')->unsigned()->index();
                $table->integer('user_id')->unsigned()->index()->nullable();
                $table->integer('accr_voters')->nullable();
                $table->integer('void_voters')->nullable();
                $table->integer('status');
                $table->integer('step')->default(1);
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
            foreach($C as $c){
                $insertData = [
                    "election_id"=>$election,
                    "state_id"=>$state_id,
                    "constituency_id"=>$constituency_id,
                    "lga_id"=>$c->lga_id,
                    "ward_id"=>$c->ward_id,
                    "polling_station_id"=>$c->id,
                    "accr_voters"=>0,
                    "void_voters"=>0,
                    "confirmed_voters"=>0,
                    "status"=>1
                ];
                foreach($parties as $key=>$v){
                    $party_code = \App\PoliticalParty::find($v);
                    $p = strtolower($party_code['code']);
                    $insertData[$p] = 0;
                }

                \DB::table("polling_".$ElectionCode."_results")->insert($insertData);

                //creating api token access for each polling unit under this election
                $token = new \App\ElectionOnetimePassword();
                $token->election_id = $election;
                $token->state_id = $state_id;
                $token->constituency_id = $constituency_id;
                $token->lga_id = $c->lga_id;
                $token->ward_id = $c->ward_id;
                $token->polling_unit_id = $c->id;
                $token->otp = rand(111111,999999);
                $token->api_token = str_random(60);
                $token->save();
            }

            $time_end = microtime(true);
            $execution_time = ($time_end - $time_start)/60;

            \DB::commit();
            return redirect()->back()->with("success","Election has been created successfully in $execution_time Mins");

        } catch(Exception $e) {
            \DB::rollback();
            return redirect()->back()->with("error","error occured");
        }
    }



    public function AjaxProcess(Request $request)
    {
        $data = $request->except('_token');

        if($data['req'] == 'viewLga') {
            $lga['lgas'] = Lga::where('state_id','=',$data['state_id'])
                    ->where('constituency_id','=',$data['constituency_id'])->get();
            return view('admin.election.modals.partials._populate_lgas')->with($lga);
        }

        if($data['req'] == 'viewConst') {
            $lga['constituency'] = Constituency::where('state_id','=',$data['state_id'])->get();
            return view('admin.election.modals.partials._populate_constituencies')->with($lga);
        }

        if($data['req'] == 'displayWard') {
            $lga['wards'] = Ward::where('state_id','=',config('constants.ACTIVE_STATE_ID'))
                            ->where('lga_id','=',$data['lga_id'])->get();
            return view('admin.election.modals.partials._populate_wards')->with($lga);
        }

        if($data['req'] == 'displayCentre') {
            $lga['centres'] = PollingStation::where('state_id','=',config('constants.ACTIVE_STATE_ID'))
                            ->where('lga_id','=',$data['lga_id'])
                            ->where('ward_id','=',$data['ward_id'])->get();
            return view('admin.election.modals.partials._populate_centres')->with($lga);
        }

        if($data['req'] == 'assignCandidate') {
            $election = Election::find($data['slug'],'slug');

             //resseting to default
            \DB::table("election_candidates")->where('election_id','=',$election['id'])->delete();

            \DB::beginTransaction();
            try{
                //assign a new candidate to the election
                $assign = \DB::table("election_candidates")->insert([
                    'election_id' => $election['id'],
                    'user_id' => $data['user_id'],
                ]);

                \DB::commit();
                if($assign){
                    return 'true';
                } else {
                    return false;
                }

            } catch(Exception $e) {
                \DB::rollback();
                return false;
            } 
        }
    }



    public function changeStatus(Request $request){
        $data = $request->all();

        if($data['type'] == 'begin'){
            \DB::beginTransaction();
            try{
                $election = Election::find($data['election_id'],'slug');
                $election->election_status_id = 2;
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
                $election->election_status_id = 3;
                $election->save();

                \DB::commit();
                return redirect()->back()->with('success','Status changed successfully. Election ended.');

            } catch(Exception $e){
                \DB::rollback();
                return redirect()->back()->with('error','An error occured');
            }
        }
    }


    public function showStats(Request $request) {
        $param = $request->except('_token');

        $data['election'] = Election::find($param['slug'],'slug');
        $data['pollingUnits'] = $data['election']->fnPollingUnits()->first();
        $data['resultSummary'] = $data['election']->get_all_total_result();
        // $data['latestResult'] = $data['election']->get_result_summary('state',config('constants.ACTIVE_STATE_ID'))
        //                     ->orderBy('id','ASC')->where('status','=',2)->get();

        //passing charts to the view
        if($data['election']['election_type_id'] == 1){
            
        } elseif($data['election']['election_type_id'] == 2){
            
            $data['pieChart'] = displayCharts('pie','state',$data['election'],$data['pollingUnits']->state_id);
            $data['barChart'] = displayCharts('bar','state',$data['election'],$data['pollingUnits']->state_id);
            $data['areaChart'] = displayCharts('area','state',$data['election'],$data['pollingUnits']->state_id);
            $data['donutChart'] = displayCharts('donut','state',$data['election'],$data['pollingUnits']->state_id);
            
            //sending latest submittee result to the view
            $data['latest'] = $data['election']->get_latest_submitted_result();
            $data['parties'] = $data['election']->fnAssignParties()->get();

        } elseif($data['election']['election_type_id'] == 3) {

            $data['pieChart'] = displayCharts('pie','constituency',$data['election'],$data['pollingUnits']->state_id,$data['pollingUnits']->constituency_id);
            $data['barChart'] = displayCharts('bar','constituency',$data['election'],$data['pollingUnits']->state_id,$data['pollingUnits']->constituency_id);
            $data['areaChart'] = displayCharts('area','constituency',$data['election'],$data['pollingUnits']->state_id,$data['pollingUnits']->constituency_id);
            $data['donutChart'] = displayCharts('donut','constituency',$data['election'],$data['pollingUnits']->state_id,$data['pollingUnits']->constituency_id);

            //sending latest submittee result to the view
            $data['latest'] = $data['election']->get_latest_submitted_result();
            $data['parties'] = $data['election']->fnAssignParties()->get();

        } elseif($data['election']['election_type_id'] == 4){

            $data['pieChart'] = displayCharts('pie','local',$data['election'],$data['pollingUnits']->state_id,$data['pollingUnits']->constituency_id,$data['pollingUnits']->lga_id);
            $data['barChart'] = displayCharts('bar','local',$data['election'],$data['pollingUnits']->state_id,$data['pollingUnits']->constituency_id,$data['pollingUnits']->lga_id);
            $data['areaChart'] = displayCharts('area','local',$data['election'],$data['pollingUnits']->state_id,$data['pollingUnits']->constituency_id,$data['pollingUnits']->lga_id);
            $data['donutChart'] = displayCharts('donut','local',$data['election'],$data['pollingUnits']->state_id,$data['pollingUnits']->constituency_id,$data['pollingUnits']->lga_id);
            $data['wards'] = Ward::where("state_id","=",$data['pollingUnits']->state_id)
                    ->where("constituency_id","=",$data['pollingUnits']->constituency_id)
                    ->where("lga_id","=",$data['pollingUnits']->lga_id)->get();

            //sending latest submittee result to the view
            $data['latest'] = $data['election']->get_latest_submitted_result();
            $data['parties'] = $data['election']->fnAssignParties()->get();
        }

        return view('admin.election.partials._show_current_stats')->with($data);
    }



    public function passcodeView($id) 
    {
        $data['election'] = Election::find($id,'slug');
        $data['passcodes'] = ElectionOnetimePassword::where('election_id','=',$data['election']['id'])->get();

        return view('admin.election.passcode')->with($data);
    }

    public function InfographicView($id) 
    {
        $data['election'] = Election::find($id,'slug');
        $data['pollingUnits'] = $data['election']->fnPollingUnits()->first();
        $data['resultSummary'] = $data['election']->get_result_summary('state',$data['pollingUnits']->state_id);
        $data['users'] = User::all();

        $data['wards'] = Ward::where("state_id","=",$data['pollingUnits']->state_id)
                    ->where("constituency_id","=",$data['pollingUnits']->constituency_id)
                    ->where("lga_id","=",$data['pollingUnits']->lga_id)->get();
        $data['lgas'] = Lga::where("state_id","=",$data['pollingUnits']->state_id)
                    ->where("constituency_id","=",$data['pollingUnits']->constituency_id)->get();

        $data['constituency'] = Constituency::where("state_id","=",$data['pollingUnits']->state_id)->get();

        return view('admin.election.view-infographics')->with($data);
    }



    public function viewSubmittedResult($id)
    {
        $data['election'] = Election::find($id,'slug');
        $ElectionCode = ElectionResultIndex::where('election_id','=',$data['election']->id)->first();
        $code = $ElectionCode['election_code'];
        $data['results'] = \DB::table("polling_".$code."_results")->where("election_id","=",$data['election']->id)->get();
        $data['parties'] = $data['election']->fnAssignParties()->get();


        return view('admin.election.view-submitted-result')->with($data);
    }


    public function queryResult(Request $request)
    {
        $param = $request->except('_token');

        if($param['req'] == 'ward-result'){
            $data['election'] = Election::find($param['slug'],'slug');
            $data['pollingUnits'] = $data['election']->fnPollingUnits()->first();
            $data['pieChart'] = displayCharts('pie','ward',$data['election'],$data['pollingUnits']->state_id,$data['pollingUnits']->constituency_id,$data['pollingUnits']->lga_id,$param['ward_id']);
            $data['barChart'] = displayCharts('bar','ward',$data['election'],$data['pollingUnits']->state_id,$data['pollingUnits']->constituency_id,$data['pollingUnits']->lga_id,$param['ward_id']);
            $data['areaChart'] = displayCharts('area','ward',$data['election'],$data['pollingUnits']->state_id,$data['pollingUnits']->constituency_id,$data['pollingUnits']->lga_id,$param['ward_id']);
            $data['donutChart'] = displayCharts('donut','ward',$data['election'],$data['pollingUnits']->state_id,$data['pollingUnits']->constituency_id,$data['pollingUnits']->lga_id,$param['ward_id']);

            return view('admin.election.partials._show_current_stats')->with($data);
        }

        if($param['req'] == 'ward-result-governor'){
            $data['election'] = Election::find($param['slug'],'slug');
            $data['pollingUnits'] = $data['election']->fnPollingUnits()->first();
            $data['pieChart'] = displayCharts('pie','ward',$data['election'],$data['pollingUnits']->state_id,$param['constituency_id'],$param['lga_id'],$param['ward_id']);
            $data['barChart'] = displayCharts('bar','ward',$data['election'],$data['pollingUnits']->state_id,$param['constituency_id'],$param['lga_id'],$param['ward_id']);
            $data['areaChart'] = displayCharts('area','ward',$data['election'],$data['pollingUnits']->state_id,$param['constituency_id'],$param['lga_id'],$param['ward_id']);
            $data['donutChart'] = displayCharts('donut','ward',$data['election'],$data['pollingUnits']->state_id,$param['constituency_id'],$param['lga_id'],$param['ward_id']);

            return view('admin.election.partials._show_current_stats')->with($data);
        }

        if($param['req'] == 'constituency-result'){
            $data['election'] = Election::find($param['slug'],'slug');
            $data['pollingUnits'] = $data['election']->fnPollingUnits()->first();
            $data['pieChart'] = displayCharts('pie','constituency',$data['election'],$data['pollingUnits']->state_id,$param['constituency_id']);
            $data['barChart'] = displayCharts('bar','constituency',$data['election'],$data['pollingUnits']->state_id,$param['constituency_id']);
            $data['areaChart'] = displayCharts('area','constituency',$data['election'],$data['pollingUnits']->state_id,$param['constituency_id']);
            $data['donutChart'] = displayCharts('donut','constituency',$data['election'],$data['pollingUnits']->state_id,$param['constituency_id']);

            return view('admin.election.partials._show_current_stats')->with($data);
        }

        if($param['req'] == 'lga-result') {
            $data['election'] = Election::find($param['slug'],'slug');
            $data['pollingUnits'] = $data['election']->fnPollingUnits()->first();
            $data['pieChart'] = displayCharts('pie','local',$data['election'],$data['pollingUnits']->state_id,$data['pollingUnits']->constituency_id,$param['lga_id']);
            $data['barChart'] = displayCharts('bar','local',$data['election'],$data['pollingUnits']->state_id,$data['pollingUnits']->constituency_id,$param['lga_id']);
            $data['areaChart'] = displayCharts('area','local',$data['election'],$data['pollingUnits']->state_id,$data['pollingUnits']->constituency_id,$param['lga_id']);
            $data['donutChart'] = displayCharts('donut','local',$data['election'],$data['pollingUnits']->state_id,$data['pollingUnits']->constituency_id,$param['lga_id']);

            return view('admin.election.partials._show_current_stats')->with($data);
        }

        if($param['req'] == 'lga-result-gov') {
            $data['election'] = Election::find($param['slug'],'slug');
            $data['pollingUnits'] = $data['election']->fnPollingUnits()->first();
            $data['pieChart'] = displayCharts('pie','local',$data['election'],$data['pollingUnits']->state_id,$param['constituency_id'],$param['lga_id']);
            $data['barChart'] = displayCharts('bar','local',$data['election'],$data['pollingUnits']->state_id,$param['constituency_id'],$param['lga_id']);
            $data['areaChart'] = displayCharts('area','local',$data['election'],$data['pollingUnits']->state_id,$param['constituency_id'],$param['lga_id']);
            $data['donutChart'] = displayCharts('donut','local',$data['election'],$data['pollingUnits']->state_id,$param['constituency_id'],$param['lga_id']);

            return view('admin.election.partials._show_current_stats')->with($data);
        }

        if($param['req'] == 'showLgas') {
            $data['election'] = Election::find($param['slug'],'slug');
            $data['pollingUnits'] = $data['election']->fnPollingUnits()->first();
            $data['lgas'] = Lga::where('state_id','=',$data['pollingUnits']->state_id)
                            ->where('constituency_id','=',$param['constituency_id'])->get();

            return view('admin.election.partials.data._show_lgas')->with($data);
        }

        if($param['req'] == 'showUnits') {
            $data['election'] = Election::find($param['slug'],'slug');
            $data['pollingUnits'] = $data['election']->fnPollingUnits()->first();
            $data['units'] = PollingStation::where('state_id','=',$data['pollingUnits']->state_id)
                            ->where('lga_id','=',$data['pollingUnits']->lga_id)
                            ->where('ward_id','=',$data['pollingUnits']->ward_id)->get();

            return view('admin.election.partials.data._show_units')->with($data);
        }

        if($param['req'] == 'showWards') {
            $data['election'] = Election::find($param['slug'],'slug');
            $data['pollingUnits'] = $data['election']->fnPollingUnits()->first();
            $data['wards'] = Ward::where('state_id','=',$data['pollingUnits']->state_id)
                            ->where('constituency_id','=',$data['pollingUnits']->constituency_id)
                            ->where('lga_id','=',$param['lga_id'])->get();

            return view('admin.election.partials.data._show_wards')->with($data);
        }

        if($param['req'] == 'unit-result') {
            $data['election'] = Election::find($param['slug'],'slug');
            $data['pollingUnits'] = $data['election']->fnPollingUnits()->first();
            $data['pieChart'] = displayCharts('pie','stations',$data['election'],$data['pollingUnits']->state_id,$data['pollingUnits']->lga_id,$param['ward_id'],$param['unit_id']);
            $data['barChart'] = displayCharts('bar','stations',$data['election'],$data['pollingUnits']->state_id,$data['pollingUnits']->lga_id,$param['ward_id'],$param['unit_id']);
            $data['areaChart'] = displayCharts('area','stations',$data['election'],$data['pollingUnits']->state_id,$data['pollingUnits']->lga_id,$param['ward_id'],$param['unit_id']);
            $data['donutChart'] = displayCharts('donut','stations',$data['election'],$data['pollingUnits']->state_id,$data['pollingUnits']->lga_id,$param['ward_id'],$param['unit_id']);

            return view('admin.election.partials._show_current_stats')->with($data);
        }

        if($param['req'] == 'unit-result-governor') {
            $data['election'] = Election::find($param['slug'],'slug');
            $data['pollingUnits'] = $data['election']->fnPollingUnits()->first();
            $data['pieChart'] = displayCharts('pie','stations',$data['election'],$data['pollingUnits']->state_id,$param['constituency_id'],$param['lga_id'],$param['ward_id'],$param['unit_id']);
            $data['barChart'] = displayCharts('bar','stations',$data['election'],$data['pollingUnits']->state_id,$param['constituency_id'],$param['lga_id'],$param['ward_id'],$param['unit_id']);
            $data['areaChart'] = displayCharts('area','stations',$data['election'],$data['pollingUnits']->state_id,$param['constituency_id'],$param['lga_id'],$param['ward_id'],$param['unit_id']);
            $data['donutChart'] = displayCharts('donut','stations',$data['election'],$data['pollingUnits']->state_id,$param['constituency_id'],$param['lga_id'],$param['ward_id'],$param['unit_id']);

            return view('admin.election.partials._show_current_stats')->with($data);
        }
    }



    //function for view a single election
    public function view($id)
    {   
        $data['election'] = Election::find($id,'slug');
        $data['pollingUnits'] = $data['election']->fnPollingUnits()->first();
        $data['resultSummary'] = $data['election']->get_result_summary('state',$data['pollingUnits']->state_id);
        $data['users'] = User::all();

        $data['wards'] = Ward::where("state_id","=",$data['pollingUnits']->state_id)
                    ->where("constituency_id","=",$data['pollingUnits']->constituency_id)
                    ->where("lga_id","=",$data['pollingUnits']->lga_id)->get();
        $data['lgas'] = Lga::where("state_id","=",$data['pollingUnits']->state_id)
                    ->where("constituency_id","=",$data['pollingUnits']->constituency_id)->get();

        $data['constituency'] = Constituency::where("state_id","=",$data['pollingUnits']->state_id)->get();
        
        return view('admin.election.view-one')->with($data);
    }


    public function reportsIndex($id){
        $data['election'] = Election::find($id,'slug');
        $data['pollingUnits'] = $data['election']->fnPollingUnits()->first();
        $data['users'] = User::all();

        $data['reports'] = PivotElectionReport::where('election_id','=',$data['election']->id)
                ->where('status','=',2)->orderBy('id','ASC')->get();
        
        return view('admin.election.reports')->with($data);
    }
}
