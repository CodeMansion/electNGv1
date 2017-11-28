<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PoliticalParty;

class PoliticalPartyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['politicalParties'] = PoliticalParty::all();

        return view('admin.political-parties.index')->with($data);
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
        
        //Avoiding saving users with the same email addresses
        if(PoliticalParty::hasCode($data['code']) == true){
            return false;
        }

        if($data['req'] == 'newPP') {
            \DB::beginTransaction();
            try{
                $pp = new PoliticalParty();
                $pp->name = $data['name'];
                $pp->slug = bin2hex(random_bytes(64));
                $pp->code = $data['code'];
                $pp->description = $data['description'];
                $pp->save();

                \DB::commit();
                return "Political Party created successfully.";

            } catch(Exception $e) {
                \DB::rollback();
                return false;
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
