<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\State;
use App\Lga;
use App\Ward;
use App\PollingStation;
class PollingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //getting everything concerning the polling station and passing it to the view
        $data['states'] = State::all();
        $data['wards'] = Ward::all();
        $data['pollings'] = PollingStation::all();

        return view('admin.polling.index')->with($data);
    }

    public function ward(Request $request)
    {
        //this is use to automatically pass the view to the user
        $output="";
        $state = \Request::get('state_id');
        $lga = \request::get('local_id');
        $lga = \App\Ward::where('state_id','=',$state)->where('lga_id',$lga)->get();
        if($lga)
        {
            foreach ($lga as $key => $local) {
              
                $output.="<option value='$local->id'>$local->name</option>";
            }
            return response()->json($output);
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
        $data = $request->except('_token');
        
        //Avoiding saving ward with the same exact data
        if(!empty(PollingStation::whereName($data['name'])->whereStateId($data['state'])->whereLgaId($data['lga'])->whereWardId($data['ward'])->first())){
            return ['error'=> 'Ooops! This PollingStation Already Exist!','type'=>'warning','title' =>'warning'];
        }

        if($data['req'] == 'newpolling'){

            \DB::beginTransaction();
            try {
                //saving new pollingstation
                $polling = new PollingStation();
                $polling->slug = bin2hex(random_bytes(64));
                $polling->state_id = $data['state'];
                $polling->lga_id = $data['lga'];
                $polling->ward_id = $data['ward'];
                $polling->name = $data['name'];
                $polling->code = bin2hex(random_bytes(4));
                $polling->save();
                
                \DB::commit();
                return response()->json(['success'=> 'PollingStation Created Successfully!','type'=>'success','title' =>'success'], 200);

            } catch(Exception $e) {
                \DB::rollback();
                return response()->json(['error'=> 'Ooops! An Error Occured!'], 200);
            }
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
    public function update(Request $request)
    {
        $data = $request->except('_token');
        //if this are still the same while update it!
        //so this check if you are trying update to the value of others! Beforeupdate is done 
        if(!empty(PollingStation::whereName($data['name'])->whereStateId($data['state'])->whereLgaId($data['lga'])->whereWardId($data['ward'])->first())){
            return ['error'=> 'Ooops! This PollingStation Already Exist!','type'=>'warning','title' =>'warning'];
        }
        if($data['req'] == 'Updatepolling'){

            \DB::beginTransaction();
            try {
                //updating pollingstation
                $polling = PollingStation::findorfail($data['id']);
                //$polling->slug = bin2hex(random_bytes(64));
                $polling->state_id = $data['state'];
                $polling->lga_id = $data['lga'];
                $polling->ward_id = $data['ward'];
                $polling->name = $data['name'];
                //$polling->code = bin2hex(random_bytes(4));
                $polling->save();
                
                \DB::commit();
                return response()->json(['success'=> 'PollingStation Updated Successfully!','type'=>'success','title' =>'success'], 200);

            } catch(Exception $e) {
                \DB::rollback();
                return response()->json(['error'=> 'Ooops! An Error Occured!'], 200);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        //deleting the data releted to each polling station
        PollingStation::find($request->id)->delete();
    }
}
