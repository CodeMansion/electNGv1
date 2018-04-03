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
use App\User;
use App\ElectionType;
use App\Constituency;
use App\ElectionPasscode;
use App\ElectionReport;
use App\ActivityLog;
use App\Preference;
use App\ElectionParty;
use App\ElectionEntry;

use App\Mail\SendPasscode;

use Charts;
use Mail;
use DB;
use Artisan;
use Session;

class ElectionController extends Controller
{
    public function index()
    {
        $data['userElections'] = \Auth::user()->elections()->get();
        $data['states'] = State::all();
        $data['politicalParties'] = PoliticalParty::orderBy('code','ASC')->get();
        $data['electionTypes'] = ElectionType::all();

        return view('admin.election.index')->with($data);
    }


    public function store(Request $request)
    {   
        $data = $request->except('_token');
        $parties = $data['party'];

        if(Election::isElectionExists($data['name']) == true){
            return $response = [
                'msg'   => "This election already exist. Try again!",
                'type'  => "false"
            ];
        }

        DB::beginTransaction();
        try {
            ini_set('max_execution_time', 0);
            $time_start = microtime(true);

            $election = Election::insertGetId([
                'name'                  => $data['name'],
                'slug'                  => bin2hex(random_bytes(64)),
                'description'           => ($data['description']) ? $data['description'] : null,
                'start_date'            => date("y-m-d",strtotime($data['start_date'])),
                'end_date'              => date("y-m-d",strtotime($data['end_date'])),
                'election_status_id'    => 1,
                'election_type_id'      => $data['type']
            ]);

            if($data['req'] == 'presidential') {
                $polling_stations = PollingStation::all();
            } elseif($data['req'] == 'governorship') { 
                $state_id = $data['state_id'];
                $polling_stations = PollingStation::where('state_id','=', $state_id)->get();
            } elseif($data['req'] == 'senatorial') {
                $state_id = $data['state_id'];
                $constituency_id = $data['constituency_id'];
                $polling_stations = PollingStation::where([
                    'state_id'          => $state_id,
                    'constituency_id'   => $constituency_id
                ])->get();

            } elseif($data['req'] == 'local') {
                $state_id = $data['state_id'];
                $constituency_id = $data['constituency_id'];
                $lga = $data['lga_id'];
        
                if($lga >= 1){
                    $polling_stations = PollingStation::where([
                        'state_id'          => $state_id,
                        'constituency_id'   => $constituency_id,
                        'lga_id'            => $lga
                    ])->get();

                } else {
                    \DB::rollback();
                    return $response = [
                        'msg'   => "No Local Govt Found. Upload LGAs before continuing",
                        'type'  => "false"
                    ];
                }
            }

            if(count($polling_stations) < 1) {
                return $response = [
                    'msg'   => "There are no polling stations on the system. Polling station data are needed!",
                    'type'  => "false"
                ];
            }
            
            foreach($parties as $key => $value){
                $election_parties = DB::table("election_parties")->insert([
                    'election_id'           => $election,
                    'political_party_id'    => $value
                ]);

                foreach($polling_stations as $station) {
                    $entries = DB::table("election_entries")->insert([
                        "election_id"           => $election,
                        "political_party_id"     => $value,
                        "party_code"            => party_code($value),
                        "state_id"              => $station->state_id,
                        "constituency_id"       => $station->constituency_id,
                        "lga_id"                => $station->lga_id,
                        "ward_id"               => $station->ward_id,
                        "polling_station_id"    => $station->id,
                        "accr_voters"           => 0,
                        "void_voters"           => 0,
                        "confirmed_voters"      => 0,
                        "votes"                 => 0
                    ]);

                    $passcode = DB::table('election_passcodes')->insert([
                        "election_id"           => $election,
                        "state_id"              => $station->state_id,
                        "constituency_id"       => $station->constituency_id,
                        "lga_id"                => $station->lga_id,
                        "ward_id"               => $station->ward_id,
                        "polling_station_id"    => $station->id,
                        "otp"                   => rand(111111,999999),
                        "api_token"             => str_random(60)
                    ]);
                }
            }		

            $user_election = DB::table("user_elections")->insert([
                'election_id'   => $election,
                'user_id'       => \Auth::user()->id,
            ]);

            $time_end = microtime(true);
            $execution_time = ($time_end - $time_start)/60;
            $time = round($execution_time);
           
            DB::commit();
            return $response = [
                'msg'   => "Completed in $time Mins",
                'type'  => "true"
            ];

        } catch(Exception $e) {
            DB::rollback();
            return $response = [
                'msg'   => "Internal Server Error",
                'type'  => "false"
            ];
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


    public function showStats(Request $request) 
    {
        $param = $request->except('_token');
        $data['election'] = Election::find($param['slug'],'slug');
        $data['barchart'] = ChartDisplay($data['election'],'bar');
        $data['linechart'] = ChartDisplay($data['election'],'line');
        $data['piechart'] = ChartDisplay($data['election'],'pie');
        $data['donutchart'] = ChartDisplay($data['election'],'donut');

        return view('admin.election.partials._show_current_stats')->with($data);
    }



    public function passcodeView($id) 
    {
        $data['election'] = Election::find($id,'slug');
        $data['passcodes'] = ElectionPasscode::where('election_id','=',$data['election']['id'])->get();

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
        $data['polling_stations'] = DB::table("election_entries")->where([
            "election_id"         => $data['election']->id,
            "is_submitted"        => true
        ])->groupBy('polling_station_id')->get();
        $data['wards'] = DB::table("election_entries")->where([
            "election_id"         => $data['election']->id,
            "is_submitted"        => true
        ])->groupBy('ward_id')->get();
        $data['lgas'] = DB::table("election_entries")->where([
            "election_id"         => $data['election']->id,
            "is_submitted"        => true
        ])->groupBy('lga_id')->get();
        $data['states'] = DB::table("election_entries")->where([
            "election_id"         => $data['election']->id,
            "is_submitted"        => true
        ])->groupBy('state_id')->get();
        $data['votes'] = DB::table("election_entries")->where([
            "election_id"         => $data['election']->id,
            "is_submitted"        => true
        ])->get();

        $data['parties'] = $data['election']->parties()->get();

        return view('admin.election.result.index')->with($data);
    }


    public function winMetricIndex($id)
    {
        $data['election'] = Election::find($id,'slug');
        $data['polling_stations'] = DB::table("election_entries")->where([
            "election_id"         => $data['election']->id,
            "is_submitted"        => true
        ])->groupBy('polling_station_id')->get();
        $data['wards'] = DB::table("election_entries")->where([
            "election_id"         => $data['election']->id,
            "is_submitted"        => true
        ])->groupBy('ward_id')->get();
        $data['lgas'] = DB::table("election_entries")->where([
            "election_id"         => $data['election']->id,
            "is_submitted"        => true
        ])->groupBy('lga_id')->get();
        $data['states'] = DB::table("election_entries")->where([
            "election_id"         => $data['election']->id,
            "is_submitted"        => true
        ])->groupBy('state_id')->get();
        $data['votes'] = DB::table("election_entries")->where([
            "election_id"         => $data['election']->id,
            "is_submitted"        => true
        ])->get();

        $data['parties'] = $data['election']->parties()->get();

        return view('admin.election.metrics.index')->with($data);
    }


    public function markStar(Request $request)
    {
        $data = $request->except('_token');
        if($data) {
            DB::beginTransaction();
            try {
                $reset = ElectionParty::where('election_id',$data['election_id'])->update(['is_star_party' => false]);
                $update = ElectionParty::where([
                    'election_id'           => $data['election_id'],
                    'political_party_id'    => $data['party_id']
                ])->first();
                $update->is_star_party = true;
                $update->save();

                DB::commit();
                return "Marked Successfully";

            } catch(Exception $e) {
                DB::rollback();
                return false;
            }
        }
    }


    public function view($id)
    {   
        $data['election'] = Election::find($id,'slug');
        $data['politicalParties'] = $data['election']->parties()->get();
        
        return view('admin.election.view-one')->with($data);
    }


    public function broadsheetIndex($slug)
    {
        $data['election'] = Election::find($slug,'slug');
        $data['politicalParties'] = $data['election']->parties()->get();
        $result = $data['election']->get_all_total_result();
        $data['barchart'] = ChartDisplay($data['election'],'bar');
        $data['linechart'] = ChartDisplay($data['election'],'line');
        $data['piechart'] = ChartDisplay($data['election'],'pie');
        $data['donutchart'] = ChartDisplay($data['election'],'donut');
        $data['setting'] = Preference::find(1);

        return view('admin.election.broadsheet')->with($data);
    }


    public function reportsIndex($id){
        $data['election'] = Election::find($id,'slug');
        $data['pollingUnits'] = $data['election']->fnPollingUnits()->first();
        $data['users'] = User::all();

        $data['reports'] = ElectionReport::where('election_id','=',$data['election']->id)
                ->where('status','=',2)->orderBy('id','ASC')->get();
        
        return view('admin.election.reports')->with($data);
    }


    public function activityLogIndex($id){
        $data['election'] = Election::find($id,'slug');
        $data['logs'] = ActivityLog::orderBy('id','ASC')->get();
        
        return view('admin.election.activity_logs')->with($data);
    }
}
