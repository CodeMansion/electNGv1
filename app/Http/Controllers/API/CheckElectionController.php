<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

use App\ElectionPasscode;
use App\Election;
use App\ElectionEntry;
use App\PoliticalParty;
use App\ElectionParty;
use Artisan;

class CheckElectionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {		
        try {
            if(ElectionPasscode::isvalid($request->get('otp'))){
                $id = ElectionPasscode::where("otp","=",$request->get('otp'))->first();
                $param['election'] = Election::find($id->election_id);
                $party = [];

                $entries = ElectionEntry::where([
                    'election_id'           => $id->election_id,
                    'state_id'              => $id->state_id,
                    'lga_id'                => $id->lga_id,
                    'ward_id'               => $id->ward_id,
                    'polling_station_id'    => $id->polling_station_id
                ])->first();

                //querying registered political parties
                $parties = ElectionParty::where('election_id','=',$id->election_id)->get();

                foreach($parties as $key => $value) {
                    $party[$key] = $value->political_party_id;
                }

                $param['parties']           = $param['election']->parties()->get();
                $param['state']             = state($id->state_id);
                $param['ward']              = ward($id->ward_id);
                $param['lga']               = lga($id->lga_id);
                $param['centre']            = centre($id->polling_station_id);
                $param['election_name']     = $param['election']->name;
                $param['resultInfo']        = $entries;
                $param['status']            = $entries->status;
                $param['api_token']         = $id['api_token'];
                $param['election_id']       = $id->election_id;
                $param['state_id']          = $id->state_id;
                $param['lga_id']            = $id->lga_id;
                $param['ward_id']           = $id->ward_id;
                $param['polling_station_id']   = $id->polling_station_id;

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
}
