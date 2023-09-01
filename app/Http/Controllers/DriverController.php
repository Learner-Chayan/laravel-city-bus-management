<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\Models\UserDetails;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Spatie\Permission\Models\Role;

class DriverController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','Setting']);
    }
    public function index()
    {
        $data['page_title'] = "Driver List";
        $user = Auth::user();
        $data['owners'] = User::where('customer_type',2)->latest()->get();//owner
        if ($user->hasRole('admin')){
            $data['drivers'] = User::where('customer_type',3)->latest()->get();//driver
        }else{
            $drivers = [];
            $userDetails = \App\Models\UserDetails::where('owner_id',$user->id)->get();
            foreach ($userDetails as $em){
                $employee = User::find($em->user_id);
                if($employee){
                    if ($employee->customer_type == 3){
                        $drivers[] = $employee;
                    }
                }
            }
            $data['drivers'] = $drivers;
        }
        return view('admin.driver.index',$data);
    }

    public function store(Request $request)
    {
        $valid = Validator::make($request->all(),[
            'owner_id' => 'required',
            'name' => 'required|string',
            'phone' => 'required|string"|unique:users,phone',
            'email' => 'required|email|unique:users,email',
            'image' => 'mimes:jpg,png,jpeg',
            'licence' => 'mimes:jpg,png,jpeg',

        ]);
        if(!$valid){
            return response()->json();
        }
        $in = $request->all();
        $in['temp_password'] = 123456;
        $in['password'] = 123456; //default password
        $in['customer_type'] = 3; // driver

        if ($request->hasFile('image'))
        {
            $image = $request->file('image');
            $imgName = uniqid().'.'.$image->getClientOriginalExtension();
            Image::make($image)->save(public_path("images/user/$imgName"));
            $in['image'] = $imgName;

        }

        $user = User::create($in);
        $role = Role::where('name','driver')->first();
        $user->roles()->attach($role);

        //user details
        $userDetails = new UserDetails();
        $userDetails->user_id = $user->id;
        $userDetails->owner_id = $request->owner_id;
        $userDetails->address = $request->address;
        if ($request->hasFile('licence'))
        {
            $image = $request->file('licence');
            $imgName = uniqid().'.'.$image->getClientOriginalExtension();
            Image::make($image)->save(public_path("images/user/$imgName"));
            $userDetails->licence = $imgName;

        }
        $userDetails->save();

        return $userDetails;
    }
    public function edit($id)
    {
        $data['page_title'] = "Driver Edit";
        $data['driver'] = User::with('userDetails')->findOrFail($id);
        $data['owners'] = User::where('customer_type',2)->latest()->get();//owner

        return view('admin.driver.edit',$data);

    }
    public function update(Request $request)
    {
        $driver = User::findOrFail($request->id);
        $valid = Validator::make($request->all(),[
            'owner_id' => 'required',
            'name' => 'required|string',
            'phone' => 'required|string"|unique:users,phone,'.$driver->id,
            'email' => 'required|email|unique:users,email,'.$driver->id,
            'image' => 'mimes:jpg,png,jpeg',
            'licence' => 'mimes:jpg,png,jpeg',

        ]);

        $in = $request->all();
        if ($request->hasFile('image'))
        {
            File::delete(public_path("images/user/$driver->image"));
            $image = $request->file('image');
            $imgName = uniqid().'.'.$image->getClientOriginalExtension();
            Image::make($image)->save(public_path("images/user/$imgName"));
            $in['image'] = $imgName;

        }
        $driver->fill($in)->save();

        //user details
        $userDetails = UserDetails::where('user_id',$driver->id)->first();
        $userDetails->user_id = $driver->id;
        $userDetails->owner_id = $request->owner_id;
        $userDetails->address = $request->address;
        if ($request->hasFile('licence'))
        {
            File::delete(public_path("images/user/$userDetails->licence"));
            $image = $request->file('licence');
            $imgName = uniqid().'.'.$image->getClientOriginalExtension();
            Image::make($image)->save(public_path("images/user/$imgName"));
            $userDetails->licence = $imgName;

        }
        $userDetails->save();
        session()->flash('message','Driver Update successfully !!');
        return redirect()->route('driver.index');
    }

}
