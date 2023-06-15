<?php

namespace App\Http\Controllers;

use App\Models\UserDetails;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Spatie\Permission\Models\Role;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','Setting','role:admin|customer']);
    }
    public function index()
    {
        $data['page_title'] = "Customer List";
        $data['customers'] = User::where('customer_type',5)->latest()->get();//customer
        return view('admin.customer.index',$data);
    }

    public function store(Request $request)
    {
//        return $request->all();
        $valid = Validator::make($request->all(),[
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
        $in['customer_type'] = 5; // customer

        if ($request->hasFile('image'))
        {
            $image = $request->file('image');
            $imgName = uniqid().'.'.$image->getClientOriginalExtension();
            Image::make($image)->save(public_path("images/user/$imgName"));
            $in['image'] = $imgName;

        }

        $user = User::create($in);
        $role = Role::where('name','customer')->first();
        $user->roles()->attach($role);

        //user details
        $userDetails = new UserDetails();
        $userDetails->user_id = $user->id;
        $userDetails->owner_id = 0;
        $userDetails->address = $request->address;
        $userDetails->save();

        return $userDetails;
    }

    public function update(Request $request)
    {
        $customer = User::findOrFail($request->id);
        $valid = Validator::make($request->all(),[
            'name' => 'required|string',
            'phone' => 'required|string"|unique:users,phone,'.$customer->id,
            'email' => 'required|email|unique:users,email,'.$customer->id,
            'image' => 'mimes:jpg,png,jpeg',

        ]);

        $in = $request->all();
        if ($request->hasFile('image'))
        {
            File::delete(public_path("images/user/$customer->image"));
            $image = $request->file('image');
            $imgName = uniqid().'.'.$image->getClientOriginalExtension();
            Image::make($image)->save(public_path("images/user/$imgName"));
            $in['image'] = $imgName;

        }
        $customer->fill($in)->save();

        //user details
        $userDetails = UserDetails::where('user_id',$customer->id)->first();
        $userDetails->user_id = $customer->id;
        $userDetails->owner_id = 0;
        $userDetails->address = $request->address;

        $userDetails->save();
        session()->flash('message','Customer Update successfully !!');
        return redirect()->route('customer.index');
    }
}
