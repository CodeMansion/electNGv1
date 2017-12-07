<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Permission;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //getting roles and permissions from the database and passing it to the view through $data[];
        $data['roles'] = Role::all();
        $data['permissions'] = Permission::all();
        return view('admin.roles.index')->with($data);
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
        // This function is use to store both role and permission differentiating them with their $data['req']i.e request
        $data = $request->except('_token');
        if($data['req'] == 'newPermission'){
            //Avoiding saving Permissions with the same exact data
            if(!empty(Permission::whereName($data['pname'])->whereLabel($data['plabel'])->first())){
                return ['error'=> 'Ooops! This Permission Already Exist!','type'=>'warning','title' =>'warning'];
            }

            \DB::beginTransaction();
            try {
                //saving new permissions 
                $permission = new Permission();
                $permission->name = $data['pname'];
                $permission->label = $data['plabel'];
                $permission->save();
                
                \DB::commit();
                return response()->json(['success'=> 'Permission Created Successfully!','type'=>'success','title' =>'success'], 200);

            } catch(Exception $e) {
                \DB::rollback();
                return response()->json(['error'=> 'Ooops! An Error Occured!'], 200);
            }
        }elseif($data['req'] == 'newRoles'){
            //Avoiding saving Roles with the same exact data
            if(!empty(Role::whereName($data['name'])->whereLabel($data['label'])->first())){
                return ['error'=> 'Ooops! This Role Already Exist!','type'=>'warning','title' =>'warning'];
            }

            \DB::beginTransaction();
            try {
                //saving new roles 
                $role = new Role();
                $role->name = $data['name'];
                $role->label = $data['label'];
                $role->save();
                
                \DB::commit();
                return response()->json(['success'=> 'Role Created Successfully!','type'=>'success','title' =>'success'], 200);

            } catch(Exception $e) {
                \DB::rollback();
                return response()->json(['error'=> 'Ooops! An Error Occured!'], 200);
            }
        }
    }

    public function assign_permission(Request $request)
    {  
        //This function is use to assign roles to permissions
        $data = $request->except('_token');
        $permission = $data['permissions'];
        if($data['req'] == 'newAsssignRoles'){

            \DB::beginTransaction();
            try {
                //saving new user and login datails
                foreach ($permission as $key => $id){
                    $check = \DB::table('permission_role')->where(['permission_id' => $id, 'role_id' => $data['roles']])->first();
                    if(!isset($check)){
                        \DB::table('permission_role')->insert(['permission_id' => $id, 'role_id' => $data['roles']]);
                    }
                    
                }
                
                \DB::commit();
                return response()->json(['success'=> 'Permission Assigned Successfully!','type'=>'success','title' =>'success'], 200);

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

    public function assign(){
        /*$role = Role::create($request->except('permission'));
        $permissions = $request->get('permission') ? $request->get('permission') : [];
        $role->givePermissionTo($permissions);*/
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
    public function destroy(Request $request)
    {
        //This is use to delete roles from permission
        $data = $request->except('_token');
        $permission = $data['check'];
        if($data['req'] == 'DeleteAsssignRoles'){

            \DB::beginTransaction();
            try {
                //delete the assigned permission
                \DB::table('permission_role')->where('permission_id', $permission)->where('role_id',$data['role'])->delete();
                /*foreach ($permission as  $id){
                    $check = \DB::table('permission_role')->where(['permission_id' => $id, 'role_id' => $data['role']])->first();
                    if(!isset($check)){
                        \DB::table('permission_role')->insert(['permission_id' => $id, 'role_id' => $data['roles']]);
                    }
                    
                }*/
                
                \DB::commit();
                return response()->json(['success'=> 'Permission Assigned Successfully!','type'=>'success','title' =>'success'], 200);

            } catch(Exception $e) {
                \DB::rollback();
                return response()->json(['error'=> 'Ooops! An Error Occured!'], 200);
            }
        }
    }
}
