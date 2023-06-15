<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth','isAdmin','Setting']);
//        $this->middleware('permission:permission',['only' => ['index']]);
//        $this->middleware('permission:permission-create',['only' => ['create']]);
//        $this->middleware('permission:permission-edit',['only' => ['edit']]);
//        $this->middleware('permission:permission-update',['only' => ['update']]);
//        $this->middleware('permission:permission-destroy',['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = 'Permission List';
        $data['permissions'] = Permission::orderByDesc('id')->get();
        return view('admin.permission.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['page_title'] = 'Permission Create';
        $data['roles'] = Role::orderByDesc('id')->get();
        return view('admin.permission.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
            // 'role' => 'required|array',
        ]);

        $roles = $request->input('role');
        $crud = ['', '-create', '-store', '-edit', '-update', '-destroy'];

        $name = $request->input('name');
        if (request('crud') == 'on') {
            foreach ($crud as $c) {
                $in['name'] = $name . $c;
                $permission = Permission::create($in);
                $permission->syncRoles($request->input('role'));
            }
        } else {
            $permission = Permission::create(['name' => $request->input('name')]);
            $permission->syncRoles($request->input('role'));
        }

        return redirect()->back()->with('message','Permission Create Successfully');
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
        $data['page_title'] = 'Edit Permission';
        $data['permission'] = Permission::findById($id);
        $data['roles'] = Role::all();
        $data['rolePermissions'] = DB::table("role_has_permissions")->where("role_has_permissions.permission_id", $id)
            ->pluck('role_has_permissions.role_id', 'role_has_permissions.role_id')
            ->all();

        return view('admin.permission.edit', $data);
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
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $id,
        ]);
        $permission = Permission::findById($id);
        $permission->update(['name' => Str::slug($request->input('name'))]);
        $permission->syncRoles($request->input('role'));

        return redirect()->back()->with('message','Permission Update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $rolePermissions = DB::table("role_has_permissions")->where("permission_id", $id)->pluck('role_id')->toArray();
        foreach ($rolePermissions as $role) {
            $r = Role::findById($role);
            $r->revokePermissionTo($permission);
        }
        $permission->delete();
        return redirect()->back()->with('message','Permission Delete successfully');

    }

}
