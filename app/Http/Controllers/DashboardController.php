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

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
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
            return view('admin.dashboard')->with($data);
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
        //
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
