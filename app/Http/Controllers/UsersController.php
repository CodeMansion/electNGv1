<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\UserProfile;
use App\UserType;
use App\Role;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['userTypes'] = UserType::all();
        $data['users'] = User::all();
        $data['roles'] = Role::all();

        return view('admin.users.index')->with($data);
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
        if(User::hasEmail($data['email']) == true){
            return redirect()->back()->with('error','Sorry a user with this email address already exist. Try again.');
        }

        if($data['req'] == 'newUser'){

            \DB::beginTransaction();
            try {
                //saving new user and login datails
                $user = new User();
                $user->slug = bin2hex(random_bytes(64));
                $user->user_type_id = $data['user_type_id'];
                $user->username = $data['username'];
                $user->email = $data['email'];
                $user->password = bcrypt('12345678');
                $user->activated = 1;
                $user->user_status_id = 1;
                $user->save();

                //storing user profile
                $profile = new UserProfile();
                $profile->slug = bin2hex(random_bytes(64));
                $profile->user_id = $user->id;
                $profile->first_name = $data['first_name'];
                $profile->last_name = $data['last_name'];
                $profile->phone = $data['phone'];
                $profile->res_address = $data['res_address'];
                $profile->save();

                //assigning role to new user
                if(isset($data['role_id'])){
                    $update = User::find($user->id)
                    ->roles()->save(
                        Role::whereId($data['role_id'])->firstOrFail()
                    );
                } else {
                    //assigning default role to user
                    $user->assignRole(2);
                }

                \DB::commit();
                return redirect()->back()->with("success","User created successfully.");

            } catch(Exception $e) {
                \DB::rollback();
                return redirect()->back()->with("error","Failed new to create user.");
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
