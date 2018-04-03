<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\State;
use App\Lga;
use App\ElectionType;
use App\Election;
use App\ElectionEntry;
use App\Ward;
use App\PollingStation;
use App\Constituency;
use App\ElectionParty;
use App\ElectionPasscode;

class SubmitResultController extends Controller
{
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $entries = $data['formData'];
        $date = new \DateTime();
        
        \DB::beginTransaction();
        try{
            //gettting the political parties
            $param['election'] = Election::find($data['election_id']);
            $param['electionParties'] = $param['election']->parties()->get();

            $reset = ElectionEntry::where([
                'election_id'   => $data['election_id']
            ])->first();
            $reset->is_latest = false;
            $reset->save();

            //collating the dataset collect from the user
            $new = [];
            $count = 0;
            foreach($param['electionParties'] as $i){
                foreach($entries as $key => $p){
                    $code = $i['code'];
                    if($code == $key){
                        $update = ElectionEntry::where([
                            'election_id'           => $data['election_id'],
                            'state_id'              => $data['state_id'],
                            'lga_id'                => $data['lga_id'],
                            'ward_id'               => $data['ward_id'],
                            'polling_station_id'    => $data['polling_station_id'],
                            'party_code'            =>  strtoupper($code)
                        ])->first();
                        $update->votes = (int)$p;
                        if($count === 1) {
                            $update->accr_voters = $data['accr_voters'];
                            $update->void_voters = $data['void_voters'];
                            $update->confirmed_voters = $data['confirmed_voters'];
                        }
                        $update->is_submitted = true;
                        $update->is_latest = true;
                        $update->save();
                    }
                }
                $count++;
            }
            
			//marking the passcode as used and making sure it is not used the second time
			ElectionPasscode::where('api_token','=',$data['token'])->update(['status'=>2]);
			
			\DB::commit();
			return response()->json([
				'data' => 'Result submitted successfully.'
			], 200);

        } catch(Exception $e) {
            \DB::rollback();
            return response()->json([
                'data' => "Unauthorized Access"
            ], 401);
        }
    }


    public function storeReports(Request $request)
    {
        $data = $request->all();
        
        \DB::beginTransaction();
        try{
            //gettting the political parties
            $param['election'] = Election::find($data['election_id']);

            $report = \DB::table("election_reports")->insert([
                'election_id' => $data['election_id'],
                'state_id' => $data['state_id'],
                'lga_id' => $data['lga_id'],
                'ward_id' => $data['ward_id'],
                'polling_unit_id' => $data['polling_unit_id'],
                'status' => 2,
                'comment' => $data['reports'],
                'title' => $data['titles'],
                'created_at' => date('Y-m-d h:m:s',$date->getTimestamp()),
                'updated_at' => date('Y-m-d h:m:s',$date->getTimestamp())
            ]);

            //notifying of new reports
            
            if($report){
                \DB::commit();
                return response()->json([
                    'data' => 'Report submitted successfully.'
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
}