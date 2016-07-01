<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Role;
use App\Model\Permission;
//use Request;
class RoleController extends Controller
{
    private $controller = 'role';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $controller = $this->controller;
      $roles = Role::select(['id','name','display_name','description','created_at'])->get();
      if(\Request::ajax())
    {
       return view('admin.roles.ajax_index',compact('roles','controller'))->render();
    }
            return view('admin.roles.index',compact('roles','controller'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::select(['id','display_name'])->get();

        //return view('admin.roles.add',compact('permissions'));

           $arr['permissions'] =  $permissions ;
         //$arr['success'] = 'Status updated successfully';
        return json_encode($arr);
            exit;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
       
       $this->validate($request, [
                'name' => 'required|unique:roles|max:50',
                'display_name' => 'required',
                'description' => 'required',
            ]);


        $role = new Role();

        $role->name         = $request->name;
        $role->display_name = $request->display_name; // optional
        $role->description  = $request->description; // optional
        $role->save();

       
         if($request->permissions)
       $role->attachPermissions($request->permissions);
        //print_r($request->all()); die('asdas');
        //return redirect()->route('admin.role.index');    
   $arr['success'] = 'Role added successfully';
        return json_encode($arr);
            exit;
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
        $role = Role::where('id',$id)->first();

        foreach ($role->perms as  $perm) {
            $selected_perms[]=$perm->id;
        }
        
        $permissions = Permission::select(['id','display_name'])->get();

       //return view('admin.roles.add',compact('role','permissions','selected_perms'));

         $arr['permissions'] =  $permissions ;
          $arr['role'] =  $role ;
           $arr['selected_perms'] =  $selected_perms ;

         //$arr['success'] = 'Status updated successfully';
        return json_encode($arr);
            exit;
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
        $id = $request->role_id;
         $this->validate($request, [
                'name' => 'required|max:50|unique:roles,name,'.$id,
                'display_name' => 'required',
                'description' => 'required',
            ]);

        $role = Role::find($id);
        $role->name         = $request->name;
        $role->display_name = $request->display_name; // optional
        $role->description  = $request->description; // optional
        $role->save();
        //detach all permissions from role
         $role->perms()->sync([]);
         //detach all users
         //$role->users()->sync([]); 
             
         if($request->permissions)
        $role->attachPermissions($request->permissions);
       
       // return redirect()->route('admin.role.index');  



         $arr['success'] = 'Role updated successfully';
        return json_encode($arr);
            exit;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //dd($id);
        //dd($request->id);
        //$id = $request->id;
        $role = Role::findorFail($id);
        $role->perms()->sync([]);
        $role->users()->sync([]); 
        $role->delete();
        //Session::flash('flash_message', 'User successfully deleted!');
        //return redirect()->intended('admin/role');
          $arr['success'] = 'Role deleted successfully';
        return json_encode($arr);
            exit;
    }

}
