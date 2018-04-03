<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Election;
use App\State;
use App\PoliticalParty;
use App\ElectionType;
use App\Ward;
use App\Lga;
use App\Constituency;

class DashboardController extends Controller
{
    public function index()
    {
        $data['elections'] = Election::all();
        $data['states'] = State::all();
        $data['politicalParties'] = PoliticalParty::orderBy('code','ASC')->get();
        $data['electionTypes'] = ElectionType::all();

        return view('admin.dashboard')->with($data);
    }
}
