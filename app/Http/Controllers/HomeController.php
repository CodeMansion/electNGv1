<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Election;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['election'] = Election::where("election_status_id",'=',3)->first();
        return view('admin.dashboard')->with($data);
    }
}
