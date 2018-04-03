<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Preference;

class PreferencesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['setting'] = Preference::find(1);

        return view('admin.preferences.index')->with($data);
    }

    public function bulkUploadIndex()
    {
        return view('admin.bulk-upload.index');
    }

    public function storeBulkUpload(Request $request)
    {
        $data = $request->except('_token');

        if($request->hasFile('file')){
            try {
                ini_set('max_execution_time',0);
                $time_start = microtime(true);
                
                bulkUpload($data['upload_type'],$data['query_type'],$request->file('file'));
                
                $time_end = microtime(true);
                $execution_time = ($time_end - $time_start)/60;
                $time = round($execution_time);

                return $response = [
                    'msg'   => "Upload Completed successfully in $time Mins",
                    'type'  => "true"
                ];

            } catch(Exception $e) {
                return $response = [
                    'msg'   => "File could not upload",
                    'type'  => "false"
                ];
            }
 
        } else { 
            return $response = [
                'msg' => "Invalid file!",
                'type' => "false"
            ]; 
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
        \DB::beginTransaction();
        try {
            $update = Preference::where("id","=",1)->update([
                'enable_page_refresh'              => $data['page_refresh'],
                'enable_sound_notification'        => $data['sound_notification'],
                'enable_integrity_check'           => $data['integrity_check'],
                'enable_report_image'              => $data['report_upload'],
                'enable_ward_result'               => $data['ward_result'],
                'enable_result_override'           => $data['result_override'],
                'host'                             => $data['host'],
                'port'                             => $data['port'],
                'username'                         => $data['username'],
                'password'                         => $data['password'],
                'encryption'                       => $data['encryption']
            ]);

            \DB::commit();
            return $response = [
                'msg'   => "Updated Successfully",
                'type'  => "true"
            ];

        } catch(Exception $e) {
            \DB::rollback();
            return $response = [
                'msg' => "Internal Server Error",
                'type' => "false"
            ]; 
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
