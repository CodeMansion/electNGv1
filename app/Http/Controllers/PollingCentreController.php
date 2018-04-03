<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\State;
use App\Lga;
use App\Ward;
use App\PollingStation;

class PollingCentreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['states'] = State::all();

        return view('admin.polling-stations.index')->with($data);
    }

    public function getLga(Request $request) {
        $data = $request->except('_token');
        $param['lgas'] = Lga::where('state_id',$data['state_id'])->get();

        return view('admin.polling-stations.partials._lgas')->with($param);
    }

    public function getWard(Request $request) {
        $data = $request->except('_token');
        $param['wards'] = Ward::where('lga_id',$data['lga_id'])->get();

        return view('admin.polling-stations.partials._ward')->with($param);
    }

    public function getpollingStations(Request $request) {
        $data = $request->except('_token');
        $param['pollingStations'] = PollingStation::where('ward_id',$data['ward_id'])->get();

        return view('admin.polling-stations.partials._polling_station')->with($param);
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
