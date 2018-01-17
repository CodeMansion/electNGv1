<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

use App\ElectionOnetimePassword;
use App\Election;
use App\ElectionResultIndex;
use App\PoliticalParty;

class CheckElectionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            if(ElectionOnetimePassword::isvalid($request->get('otp'))){
                $id = ElectionOnetimePassword::where("otp","=",$request->get('otp'))->first();
                $param['election'] = Election::find($id->election_id);
                $party = [];

                //getting the election index code
                $IndexCode = ElectionResultIndex::where('election_id','=',$id->election_id)->first();
                $IC = $IndexCode['election_code'];

                //query the election result table
                $resultInfo = \DB::table("polling_".$IC."_results")
                        ->where('election_id','=',$id->election_id)
                        ->where('state_id','=',$id->state_id)
                        // ->where('constituency_id','=',$id->constituency_id)
                        ->where('lga_id','=',$id->lga_id)
                        ->where('ward_id','=',$id->ward_id)
                        ->where('polling_station_id','=',$id->polling_unit_id)
                        ->first();

                //querying registered political parties
                $parties = \DB::table("pivot_election_parties")->where('election_id','=',$id->election_id)->get();

                foreach($parties as $key=>$v){
                    $party[$key] = $v->political_party_id;
                }

                $param['parties'] = PoliticalParty::whereIn('id',$party)->get();
                $param['state'] = state($id->state_id);
                $param['ward'] = ward($id->ward_id);
                $param['lga'] = lga($id->lga_id);
                $param['centre'] = centre($id->polling_unit_id);
                $param['election_name'] = $param['election']->name;
                $param['resultInfo'] = $resultInfo;
                $param['electionParties'] = $param['election']->fnAssignParties($id->state_id)->get();
                $param['status'] = $resultInfo->status;
                $param['api_token'] = $id['api_token'];
                $param['election_id'] = $id->election_id;
                $param['state_id'] = $id->state_id;
                $param['lga_id'] = $id->lga_id;
                $param['ward_id'] = $id->ward_id;
                $param['polling_unit_id'] = $id->polling_unit_id;

                return response()->json([
                    'data' => $param
                ]);

            } else {
                return response()->json([
                    'data' => "Unauthorized Access"
                ], 401);
            }
        } catch(Exception $e) {
            return response()->json([
                'data' => "Unauthorized Access"
            ], 401);
        }
    }

    public function getParties(Request $request) {
        $data = $request->all();
        if($data) {
            $id['election'] = Election::find($data['election_id']);
            $param['electionParties'] = $id['election']->fnAssignParties($data['state_id'])->get();
    
            if($param) {
                return response()->json([
                    'data' => $param
                ]);
            } else {
                return response()->json([
                    'data' => "Unauthorized Access"
                ], 401);
            }
        } else {
            return response()->json([
                'data' => "Invalid Request"
            ], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if(isset($request)) {
            $election = Election::find($request->get('election_id'));
            $content['name'] = $election->name;
            $content['type'] = $election->election_type_id;
            $content['status'] = $election->status;

            return response()->json([
                'data' => $content,
            ]);

        } else {
            return response()->json([
                'data' => "Unauthorized Access"
            ], 401);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
