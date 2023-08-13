<?php

namespace App\Http\Controllers;

use App\Models\UserDetails;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Spatie\Permission\Models\Role;

class HelperController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','Setting']);
    }
    public function index()
    {
        $data['page_title'] = "Helper List";
        $user = Auth::user();
        $data['owners'] = User::where('customer_type',2)->latest()->get();//owner

        if ($user->hasRole('admin')){
            $data['helpers'] = User::where('customer_type',6)->latest()->get();//helper
        }else{
            $helpers = [];
            $userDetails = \App\Models\UserDetails::where('owner_id',$user->id)->get();
            foreach ($userDetails as $em){
                $employee = User::findOrFail($em->user_id);
                if ($employee->customer_type == 6){
                    $helpers[] = $employee;
                }
            }
            $data['helpers'] = $helpers;
        }

        return view('admin.helper.index',$data);
    }

    public function store(Request $request)
    {
        $valid = Validator::make($request->all(),[
            'owner_id' => 'required',
            'name' => 'required|string',
            'phone' => 'required|string"|unique:users,phone',
            'email' => 'required|email|unique:users,email',
            'image' => 'mimes:jpg,png,jpeg',

        ]);
        if(!$valid){
            return response()->json();
        }
        $in = $request->all();
        $in['temp_password'] = 123456;
        $in['password'] = 123456; //default password
        $in['customer_type'] = 6; // helper

        if ($request->hasFile('image'))
        {
            $image = $request->file('image');
            $imgName = uniqid().'.'.$image->getClientOriginalExtension();
            Image::make($image)->save(public_path("images/user/$imgName"));
            $in['image'] = $imgName;

        }

        $user = User::create($in);
        $role = Role::where('name','helper')->first();
        $user->roles()->attach($role);

        //user details
        $userDetails = new UserDetails();
        $userDetails->user_id = $user->id;
        $userDetails->owner_id = $request->owner_id;
        $userDetails->address = $request->address;

        $userDetails->save();

        return $userDetails;
    }
    public function edit($id)
    {
        $data['page_title'] = "Helper Edit";
        $data['helper'] = User::with('userDetails')->findOrFail($id);
        $data['owners'] = User::where('customer_type',2)->latest()->get();//owner

        return view('admin.helper.edit',$data);

    }
    public function update(Request $request)
    {
        $helper = User::findOrFail($request->id);
        $valid = Validator::make($request->all(),[
            'owner_id' => 'required',
            'name' => 'required|string',
            'phone' => 'required|string"|unique:users,phone,'.$helper->id,
            'email' => 'required|email|unique:users,email,'.$helper->id,
            'image' => 'mimes:jpg,png,jpeg',

        ]);

        $in = $request->all();
        if ($request->hasFile('image'))
        {
            File::delete(public_path("images/user/$helper->image"));
            $image = $request->file('image');
            $imgName = uniqid().'.'.$image->getClientOriginalExtension();
            Image::make($image)->save(public_path("images/user/$imgName"));
            $in['image'] = $imgName;

        }
        $helper->fill($in)->save();

        //user details
        $userDetails = UserDetails::where('user_id',$helper->id)->first();
        $userDetails->user_id = $helper->id;
        $userDetails->owner_id = $request->owner_id;
        $userDetails->address = $request->address;

        $userDetails->save();
        session()->flash('message','Helper Update successfully !!');
        return redirect()->route('helper.index');
    }
}
