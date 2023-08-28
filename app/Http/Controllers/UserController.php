<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth','isAdmin','Setting']);
    }

    public function index()
    {
        $page_title = "Manage User";
        $data = User::with('roles')->get();
        return view('admin.users.index',compact('data','page_title'));
    }


    public function create()
    {
        $page_title = "New User Create";
        $roles = Role::all();
        return view('admin.users.create',compact('roles','page_title'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
        ]);
        $role = $request->roles;
        $tem = $request->password;
        $input = $request->all();
        $input['temp_password'] = $tem;
        $input['name'] = $input['first_name']." ".$input['last_name'];

        //admin = 1 , owner = 2 , driver = 3, checker = 4 , customer = 5 , helper = 6
        if ($role == 'admin'){
            $input['customer_type'] = 1;
        }
        elseif ($role == 'owner') {
            $input['customer_type'] = 2;
        }
        elseif ($role == 'driver') {
            $input['customer_type'] = 3;
        }elseif ($role == 'checker') {
            $input['customer_type'] = 4;
        }elseif ($role == 'helper') {
            $input['customer_type'] = 6;
        }else{
            //customer
            $input['customer_type'] = 5;
        }


        $customer = User::create($input);
//        $this->customerSend($customer);
        $customer->assignRole($request->input('roles'));

        return redirect()->route('users.index')->with('message','User Created Successfully');

    }

    public function show($id)
    {
        $page_title = "User Show";
        $user = User::find($id);
        return view('admin.users.show',compact('user','page_title'));
    }


    public function edit($id) {
        $data['page_title'] = "User Edit";
        $data['user'] = User::findOrFail($id);
        $data['roles'] = Role::get();
        return view('admin.users.edit',$data);

    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'required|min:6',
        ]);

        if($user->id !== 1) {
            $this->validate($request,[
                'password' => 'required|min:6',
            ]);
            $role = Role::findOrFail($request->roles);
            $user->temp_password = $request->password;
            $user->password = $request->password;
            $user->name = $request->name;
            $user->last_name = $request->last_name;
            $user->phone = $request->phone;
            $user->email = $request->email;
            if ($role->name == 'admin'){
                $user->customer_type = 1;
            }
            elseif ($role->name == 'delivery-boy'){
                $user->customer_type = 2;
            }

            $roles = $request['roles'];
        }
        $user->save();

        if($user->id !== 1){
            if (isset($roles)) {
                $user->roles()->sync($roles);
            }
            else {
                $user->roles()->detach();
            }
        }
        return redirect()->route('users.index')
            ->with('message','User updated successfully');
    }

    public function destroy(Request $request,$id)
    {

        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('message','User deleted successfully');
    }
}
