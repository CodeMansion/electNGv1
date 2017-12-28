<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Election;
use App\State;
use App\PoliticalParty;
use App\ElectionType;
use App\User;
use App\Ward;
use App\Lga;
use App\Constituency;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['elections'] = Election::all();
        $data['states'] = State::all();
        $data['politicalParties'] = PoliticalParty::orderBy('code','ASC')->get();
        $data['electionTypes'] = ElectionType::all();
        $user = User::find(auth()->user()->id);

        if($user->user_type_id == 1) {
            return view('admin.election.index')->with($data);
        } elseif($user->user_type_id == 2 || $user->user_type_id == 3) {
            $id = \DB::table("election_candidates")->where("user_id","=",auth()->user()->id)->first();
            if($id){
                $election = Election::find($id->id);
        
                return redirect()->route('Election.ViewOne', ['id' => $election['slug']]);
            } else {
                return redirect('login');
            }
        }
    }
}
