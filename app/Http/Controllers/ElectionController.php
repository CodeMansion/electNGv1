<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Election;
use App\PoliticalParty;

class ElectionController extends Controller
{
    public function index()
    {
        $data['elections'] = Election::all();

        return view('admin.election.index')->with($data);
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        
        //Avoiding saving users with the same email addresses
        if(Election::isElectionExists($data['name']) == true){
            return false;
        }

        if($data['req'] == 'newElection') {
            \DB::beginTransaction();
            try{
                $election = new Election();
                $election->name = $data['name'];
                $election->slug = bin2hex(random_bytes(64));
                $election->description = $data['description'];
                $election->start_date = date("y-m-d",strtotime($data['start_date']));
                $election->end_date = date("y-m-d",strtotime($data['end_date']));
                $election->election_status_id = 1;
                $election->save();

                \DB::commit();
                return "Election has been created successfully.";

            } catch(Exception $e) {
                \DB::rollback();
                return false;
            }
        }
    }

    //function for view a single election
    public function view($id)
    {
        $data['election'] = Election::find($id,'slug');
        $data['electionParties'] = $data['election']->fnAssignParties()->get();
        $data['politicalParties'] = PoliticalParty::orderBy('code','ASC')->get();

        return view('admin.election.view-one')->with($data);
    }


    public function assignPartyToElection(Request $request)
    {
        $data = $request->except('_token');
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
}
