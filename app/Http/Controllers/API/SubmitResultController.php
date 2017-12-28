<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\State;
use App\Lga;
use App\ElectionType;
use App\Election;
use App\ElectionResultIndex;
use App\Ward;
use App\PollingStation;
use App\Constituency;

class SubmitResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
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


    public function loadStates() 
    {
        $state = State::all();
        return response()->json([
            'data' => $state->toArray(),
        ]);
    }


    public function viewConstituency(Request $request)
    {
        if(isset($request)) {
            $constituency = Constituency::where("state_id","=",$request->get('state_id'))->get();
            if(count($constituency) < 1){
                return response()->json([
                    'data' => 'Invalid Request'
                ], 400);

            } else {
                return response()->json([
                    'data' => $constituency->toArray(),
                ]);
            } 

        } else {
            return response()->json([
                'data' => 'Invalid Request'
            ], 400);
        }
    }


    public function viewLga(Request $request)
    {
        if(isset($request)) {
            $lga = Lga::where("state_id","=",$request->get('state_id'))->get();
            if(count($lga) < 1){
                return response()->json([
                    'data' => 'Invalid Request'
                ], 400);

            } else {
                return response()->json([
                    'data' => $lga->toArray(),
                ]);
            } 

        } else {
            return response()->json([
                'data' => 'Invalid Request'
            ], 400);
        }
    }


    public function viewWard(Request $request)
    {
        if(isset($request)) {
            $ward = Ward::where("state_id","=",$request->get('state_id'))
                        ->where("lga_id","=",$request->get('lga_id'))->get();
            if(count($ward) < 1){
                return response()->json([
                    'data' => 'Invalid Request'
                ], 400);

            } else {
                return response()->json([
                    'data' => $ward->toArray(),
                ]);
            } 

        } else {
            return response()->json([
                'data' => 'Invalid Request'
            ], 400);
        }
    }


    public function viewCentres(Request $request)
    {
        if(isset($request)) {
            $centres = PollingStation::where("state_id","=",$request->get('state_id'))
                        ->where("lga_id","=",$request->get('lga_id'))
                        ->where("ward_id","=",$request->get('ward_id'))->get();

            if(count($centres) < 1){
                return response()->json([
                    'data' => 'Invalid Request'
                ], 400);

            } else {
                return response()->json([
                    'data' => $centres->toArray(),
                ]);
            } 

        } else {
            return response()->json([
                'data' => 'Invalid Request'
            ], 400);
        }
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
        $data = $request->all();
        $parties = $data['formData'];
        foreach($parties as $p){
            
        }

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
                foreach($parties as $key => $p){
                    $code = $i['code'];
                    if($code == $key){
                        $new['accr_voters'] = (int)$data['accr_voters'];
                        $new['void_voters'] = (int)$data['void_voters'];
                        $new['confirmed_voters'] = (int)$data['confirmed_voters'];
                        $new['status'] = 2;
                        $new[strtolower($code)] = (int)$p;
                    }
                }
            }
            
            //updating the the election result with data from the polling station
            $resultInfo = \DB::table("polling_result_$IC")
                    ->where('election_id','=',$data['election_id'])
                    ->where('state_id','=',$data['state_id'])
                    ->where('lga_id','=',$data['lga_id'])
                    ->where('ward_id','=',$data['ward_id'])
                    ->where('polling_station_id','=',$data['polling_unit_id'])
                    ->update($new);
            
            if($resultInfo){
                //marking the passcode as used and making sure it is not used the second time
                \DB::table("election_onetime_passwords")->where('api_token','=',$data['token'])->update(['status'=>2]);
                
                \DB::commit();
                return response()->json([
                    'data' => 'Result submitted successfully.'
                ], 200);
            } else {
                return response()->json([
                    'data' => "Internal Error Occured"
                ], 401);
            }

        } catch(Exception $e) {
            \DB::rollback();
            return response()->json([
                'data' => "Unauthorized Access"
            ], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
