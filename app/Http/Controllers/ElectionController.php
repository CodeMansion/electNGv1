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

use App\Mail\SendPasscode;

use Charts;
use Mail;

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
        $data = $request->all();
        
        //Avoiding saving users with the same email addresses
        if(Election::isElectionExists($data['name']) == true){
            return false;
        }

        \DB::beginTransaction();
        try {
            electionTypes((int)$data['type'],$data);
            \DB::commit();
            return redirect()->back()->with("success","Election has been created successfully");
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
                
                $user = User::find($data['user_id']);
                $details['user'] = $user;
                $details['passcode'] = $PassCode;

                //sending the passcode to user through email and text message
                \Mail::to($user['email'])->send(new SendPasscode($details));

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
                            ->where('ward_id','=',$codeInfo->ward_id)
                            ->where('polling_station_id','=',$codeInfo->polling_station_id)
                            ->first();

            $param['resultInfo'] = $resultInfo;
            $param['passcode'] = $codeInfo->passcode;
            $param['codeStatus'] = $codeInfo->status;
            $param['electionParties'] = $param['election']->fnAssignParties()->get();

            $param['pollingResult'] = \DB::table("polling_result_$IC")
                            ->where('election_id','=',$codeInfo->election_id)
                            ->where('state_id','=',$codeInfo->state_id)
                            ->where('lga_id','=',$codeInfo->lga_id)
                            ->where('ward_id','=',$codeInfo->ward_id)
                            ->where('polling_station_id','=',$codeInfo->polling_station_id)
                            ->first();

            return view('admin.election.modals.partials._view_result_details')->with($param);
        }
    }

    public function submitResult(Request $request)
    {
        $data = $request->all();

        \DB::beginTransaction();
        try{
            //gettting the political parties
            $param['election'] = Election::find($data['election_id']);
            $param['electionParties'] = $param['election']->fnAssignParties()->get();
            //getting the election index code
            $IndexCode = ElectionResultIndex::where('election_id','=',$data['election_id'])
                            ->where('state_id','=',$data['state_id'])->first();
            $IC = $IndexCode['election_code'];

            //collating the dataset collect from the user
            $new = [];
            foreach($param['electionParties'] as $i){
                $code = strtolower($i['code']);
                $new['accr_voters'] = (int)$data['accr_voters'];
                $new['void_voters'] = (int)$data['void_voters'];
                $new['confirmed_voters'] = (int)$data['confirmed_voters'];
                $new['status'] = 2;
                $new[$code] = (int)$data[$code];
            }

            // dd($new);
            //updating the the election result with data from the polling station
            $resultInfo = \DB::table("polling_result_$IC")
                    ->where('election_id','=',$data['election_id'])
                    ->where('state_id','=',$data['state_id'])
                    ->where('lga_id','=',$data['lga_id'])
                    ->where('ward_id','=',$data['ward_id'])
                    ->where('polling_station_id','=',$data['polling_station_id'])
                    ->update($new);

            //marking the passcode as used and making sure it is not used the second time
            \DB::table("pivot_election_users_passcode")->where('passcode','=',$data['passcode'])->update(['status'=>2]);
            
            \DB::commit();
            return redirect()->back()->with('success','Adding serve.');
                        
        } catch(Exception $e) {

        }
    }

    //function for view a single election
    public function view($id)
    {
        $data['election'] = Election::find($id,'slug');
        $data['users'] = User::all();
        $data['lgas'] = Lga::where("state_id","=",config('constants.ACTIVE_STATE_ID'))->get();
        $data['electionParties'] = $data['election']->fnAssignParties()->get();
        $data['units'] = Election::find($id,'slug');
        $data['pollingUnits'] = $data['election']->fnPollingUnits()->get();
        $data['politicalParties'] = PoliticalParty::orderBy('code','ASC')->get();
        $data['pollingResults'] = $data['election']->get_polling_result('state',config('constants.ACTIVE_STATE_ID'))->get();
        $data['approvedPasscodes'] = $data['election']->fnApprovedPasscodes()->get();
        $data['resultSummary'] = $data['election']->get_result_summary('state',config('constants.ACTIVE_STATE_ID'));

        //passing charts to the view
        $data['pieChart'] = $this->displayCharts('pie','state',$data['election'],config('constants.ACTIVE_STATE_ID'));
        $data['barChart'] = $this->displayCharts('bar','state',$data['election'],config('constants.ACTIVE_STATE_ID'));
        // $data['areaChart'] = $this->displayCharts('area',$data['election']);
        // $data['donutChart'] = $this->displayCharts('donut',$data['election']);
        
        return view('admin.election.view-one')->with($data);
    }

    protected function displayCharts($name=null,$level=null,$election=null,
    $state_id=null,$const_id=null,$lga_id=null,$ward_id=null,$unit_id=null)
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
                $result = $election->get_result_summary('local',$state_id,$lga_id);
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
                $result = $election->get_result_summary('ward',$state_id,$lga_id,$ward_id);
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
                $barChart = Charts::create('bar', 'highcharts')->title('Showing Result With Bar Chart')->labels($data)->values($value)->responsive(false);
                
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
                $barChart = Charts::create('bar', 'highcharts')->title('Showing Result With Bar Chart')->labels($data)->values($value)->responsive(false);
                
                return $barChart;
            }

            if($level == 'local'){
                $data = []; $value = [];$count = 0;$new = [];
                $result = $election->get_result_summary('local',$state_id,$lga_id);
                foreach($result as $key => $v){
                    $data[$count] = $key;
                    $value[$count] = $v;
                    $count++;
                }
                array_values($data);array_values($value);
                $barChart = Charts::create('bar', 'highcharts')->title('Showing Result With Bar Chart')->labels($data)->values($value)->responsive(false);
                
                return $barChart;
            }

            if($level == 'ward'){
                $data = []; $value = [];$count = 0;$new = [];
                $result = $election->get_result_summary('ward',$state_id,$lga_id,$ward_id);
                foreach($result as $key => $v){
                    $data[$count] = $key;
                    $value[$count] = $v;
                    $count++;
                }
                array_values($data);array_values($value);
                $barChart = Charts::create('bar', 'highcharts')->title('Showing Result With Bar Chart')->labels($data)->values($value)->responsive(false);
                
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
                $barChart = Charts::create('bar', 'highcharts')->title('Showing Result With Bar Chart')->labels($data)->values($value)->responsive(false);
                
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
                $result = $election->get_result_summary('local',$state_id,$lga_id);
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
                $result = $election->get_result_summary('ward',$state_id,$lga_id,$ward_id);
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
                $result = $election->get_result_summary('local',$state_id,$lga_id);
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
                $result = $election->get_result_summary('ward',$state_id,$lga_id,$ward_id);
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
}
