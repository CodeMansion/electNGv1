<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PreferencesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.bulk-upload.index');
    }

    public function bulkUploadIndex()
    {
        return view('admin.bulk-upload.bulk-upload-index');
    }

    public function storeBulkUpload(Request $request)
    {
        if($request->hasFile('file')){
            
             try {
                 ini_set('max_execution_time', 300);
                 $time_start = microtime(true);
                 
                 bulkUpload($request->get('upload-type'),$request->file('file'));
 
                 $time_end = microtime(true);
                 $execution_time = ($time_end - $time_start)/60;
                 return redirect()->back()->with('success',"Upload Completed successfully in $execution_time Mins");
 
             } catch(Exception $e) {
                 return redirect()->back()->with("error",$e->getMessage());
             }
 
         } else { return redirect()->back()->with("error","Invalid Request"); }
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
