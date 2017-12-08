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
        //this is geeting everything abut the user and passing it to the view
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
                $user->password = '12345678';
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
    public function update(Request $request)
    {
        //Updating the user details
        $data = $request->all();
        if($data['req'] == 'UpdateUser'){

            \DB::beginTransaction();
            try {
                //saving new user and login datails
                $user = User::findorfail($data['id']);
                $user->user_type_id = $data['user_type_id'];
                $user->username = $data['username'];
                $user->email = $data['email'];
                $user->save();

                //storing user profile
                $profile = UserProfile::whereUserId($data['id'])->first();
                $profile->first_name = $data['first_name'];
                $profile->last_name = $data['last_name'];
                $profile->phone = $data['phone'];
                $profile->res_address = $data['res_address'];
                $profile->save();

                //assigning role to new user
                if(isset($data['role_id'])){
                    $check = \DB::table('role_user')->where(['role_id'=>$data['role_id']])->first();
                    if(!isset($check)){
                       $update = User::find($user->id)
                        ->roles()->save(
                            Role::whereId($data['role_id'])->firstOrFail()
                        ); 
                    }
                    
                } else {
                    //assigning default role to user
                    $user->assignRole(2);
                }

                \DB::commit();
                return redirect()->back()->with("success","User Updated successfully.");

            } catch(Exception $e) {
                \DB::rollback();
                return redirect()->back()->with("error","Failed to update user.");
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
        //deleting the user and other table where is id is relevant.
        $id = $request->id;
        \DB::beginTransaction();
        try 
        {
            $user = User::whereId($id)->first();
            $user->delete();
            $profile = UserProfile::whereUserId($id)->first()->delete();
            \DB::table('role_user')->where('user_id',$id)->delete();
            \DB::commit();
            return redirect()->back()->with("success","User Updated successfully.");

        } catch(Exception $e) {
            \DB::rollback();
            return redirect()->back()->with("error","Failed to delete user.");
        }
    }
}
