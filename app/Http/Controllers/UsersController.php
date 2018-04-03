<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\UserProfile;
use App\UserType;
use App\Role;
use App\UserCategory;
use App\Gender;
use App\State;
use Validator;

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
        $data['categories'] = UserCategory::all();
        $data['users'] = User::all();
        $data['roles'] = Role::all();
        $data['genders'] = Gender::all();
        $data['states'] = State::all();

        return view('admin.users.index')->with($data);
    }


    protected function insertValidator(array $data) {
        $niceMsg = [
            'surname'       => 'Surname',
            'category_id'   => 'User category',
            'gender_id'     => 'Gender',
            'state_id'      => 'State of origin',
            'email'         => 'Email Address',
            'telephone'     => 'Telephone number',
            'role_id'       => 'User role',
        ];

        return Validator::make($data, [
            'surname'               => 'bail|required',
            'other_names'           => 'bail|required',
            'category_id'           => 'bail|required',
            'gender_id'             => 'bail|required',
            'state_id'              => 'bail|required',
            'role_id'               => 'bail|required',
            'email'                 => 'bail|required|email',
            'telephone'             => 'bail|required|min:11|max:11',
            'address'               => 'bail|required',
        ], $niceMsg);
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
        if(User::hasEmail($data['email']) || UserProfile::hasEmail($data['email'])){
            return $response = [
                "msg"   => "This email address already exist",
                "type"  => "false"
            ];
        }

        $validate = $this->insertValidator($request->except('_token'));
        if($validate->fails()) {
            return $response = [
                'msg'   => $validate->errors(),
                'type'  => 'false'
            ];
        }

        \DB::beginTransaction();
        try {

            $user = \DB::table("users")->insertGetId([
                'slug'              => bin2hex(random_bytes(64)),
                'user_category_id'  => $data['category_id'],
                'surname'           => ucfirst($data['surname']),
                'other_names'       => ucwords($data['other_names']),
                'email'             => $data['email'],
                'password'          => bcrypt('Pass1234@'),
            ]);

            $profile = \DB::table("user_profiles")->insert([
                'slug'              => bin2hex(random_bytes(64)),
                'last_name'         => $data['surname'],
                'other_names'       => $data['other_names'],
                'email'             => $data['email'],
                'telephone'         => $data['telephone'],
                'gender_id'         => $data['gender_id'],
                'user_id'           => $user,
                'state_id'          => $data['state_id'],
                'address'           => $data['address'],
                'status'            => 1
            ]);

            if(isset($data['role_id'])){
                $update = User::find($user)
                ->roles()->save(
                    Role::whereId($data['role_id'])->firstOrFail()
                );
            } else {
                $update = User::find($user)->assignRole(2);
            }

            \DB::commit();
            return $response = [
                'msg'   => 'Created Successfully',
                'type'  => 'true'
            ];

        } catch(Exception $e) {
            \DB::rollback();
            return $response = [
                'msg'   => $e->getMessage(),
                'type'  => 'false'
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
