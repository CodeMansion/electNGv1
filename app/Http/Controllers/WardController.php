<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\State;
use App\Lga;
use App\Ward;
class WardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //this is use in getting wards and state from the database and passing it to the view through $data[];
        $data['states'] = State::all();
        $data['wards'] = Ward::all();

        return view('admin.ward.index')->with($data);
    }

    public function state_lga(Request $request)
    {
        $output="";
        $state = \Request::get('state_id');
        $lga = \App\Lga::where('state_id','=',$state)->get();
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
        if(!empty(Ward::whereName($data['name'])->whereStateId($data['state'])->whereLgaId($data['lga'])->first())){
            return ['error'=> 'Ooops! This ward Already Exist!','type'=>'warning','title' =>'warning'];
        }

        if($data['req'] == 'newWard'){

            \DB::beginTransaction();
            try {
                //saving new ward in to the database
                $ward = new Ward();
                $ward->slug = bin2hex(random_bytes(64));
                $ward->state_id = $data['state'];
                $ward->lga_id = $data['lga'];
                $ward->name = $data['name'];
                $ward->code = bin2hex(random_bytes(4));
                $ward->save();
                
                \DB::commit();
                return response()->json(['success'=> 'Ward Created Successfully!','type'=>'success','title' =>'success'], 200);

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
        if(!empty(Ward::whereName($data['name'])->whereStateId($data['state'])->whereLgaId($data['lga'])->first())){
            return ['error'=> 'Ooops! This ward Already Exist!','type'=>'warning','title' =>'warning'];
        }
        if($data['req'] == 'UpdateWard'){

            \DB::beginTransaction();
            try {
                //updating the ward
                $ward = ward::findorfail($data['id']);
                //$ward->slug = bin2hex(random_bytes(64));
                $ward->state_id = $data['state'];
                $ward->lga_id = $data['lga'];
                $ward->name = $data['name'];
                //$ward->code = bin2hex(random_bytes(4));
                $ward->save();
                
                \DB::commit();
                return response()->json(['success'=> 'Ward Updated Successfully!','type'=>'success','title' =>'success'], 200);

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
        //delete ward with this id
        Ward::find($request->id)->delete();
    }
}
