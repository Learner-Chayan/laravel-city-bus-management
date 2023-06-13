<?php

namespace App\Http\Controllers;

use App\Models\Owner;
use App\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Spatie\Permission\Models\Role;

class OwnerController extends Controller
{
   public function __construct()
   {
       $this->middleware(['auth','Setting']);
   }
    public function index()
    {
        $data['page_title'] = "Owner List";
        $data['owners'] = User::where('customer_type',2)->latest()->get();
        return view('admin.owner.index',$data);
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
        $valid = Validator::make($request->all(),[
            'name' => 'required|string',
            'phone' => 'required|string"|unique:users,phone',
            'email' => 'required|email|unique:users,email',

        ]);
        if(!$valid){
            return response()->json();
        }
        $in = $request->all();
        if ($request->hasFile('image'))
        {
            $image = $request->file('image');
            $imgName = uniqid().'.'.$image->getClientOriginalExtension();
//            return response()->json($imgName);
            Image::make($image)->save(public_path("images/user/$imgName"));
            $in['image'] = $imgName;

        }
        $user = User::create($in);

        $role = Role::where('name','owner')->first();
        $user->roles()->attach($role);
        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Owner  $owner
     * @return \Illuminate\Http\Response
     */
    public function show(Owner $owner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Owner  $owner
     * @return \Illuminate\Http\Response
     */
    public function edit(Owner $owner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Owner  $owner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $owner = User::findOrFail($request->id);
        $valid = Validator::make($request->all(),[
            'name' => 'required|string',
            'phone' => 'required|string"|unique:users,phone,'.$owner->id,
            'email' => 'required|email|unique:users,email,'.$owner->id,

        ]);
        if(!$valid){
            return response()->json();
        }
        $in = $request->all();
        $in['temp_password'] = 123456;
        $in['password'] = 123456; //default password
        $in['customer_type'] = 2; // owner
        if ($request->hasFile('image'))
        {
            File::delete(public_path("images/user/$owner->image"));
            $image = $request->file('image');
            $imgName = uniqid().'.'.$image->getClientOriginalExtension();
            Image::make($image)->save(public_path("images/user/$imgName"));
            $in['image'] = $imgName;

        }
        $owner->fill($in)->save();

        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Owner  $owner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Owner $owner)
    {
        //
    }
}
