<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','role:admin|customer|employee|owner','Setting']);
    }

    public function dashboard()
    {
        $data['page_title'] = "Dashboard";
        return view('admin.dashboard.dashboard',$data);
    }
    public function editProfile()
    {
        $data['page_title'] = "Edit Your Profile";
        $data['user'] = User::findOrFail(Auth::user()->id);
        return view('admin.dashboard.edit-profile',$data);
    }
    public function updateProfile(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);
        $request->validate([
            'name' => 'required',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'phone' =>'required|unique:users,phone,'.$user->id,
            'image' => 'image|mimes:jpg,png,jpeg',

        ]);
        $in = $request->only('name','email','phone','image','last_name');
        if ($request->hasFile('image'))
        {
            File::delete(public_path("images/user/$user->image"));
            $image = $request->file('image');
            $image_name = rand(00000,19999).'.'.$image->getClientOriginalExtension();
            Image::make($image)->resize(215,215)->save(public_path("images/user/$image_name"));
            $in['image'] = $image_name;

        }
        $user->update($in);
        return redirect()->back()->with('message','Profile Update Successfully');
    }

    public function changePassword ()
    {
        $data['page_title'] = "Change Your Password";
        return view('admin.dashboard.change-password',$data);
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:6|same:confirm-password',
        ]);
        $temp = $request->password;
        $current_password = Auth::user()->getAuthPassword();
        $user = Auth::user();
        if (Hash::check($request->old_password, $current_password))
        {
            $user->password = $request->password;
            $user->temp_password = $temp;
            $user->save();
            return redirect()->back()->with('message','Password Change Successfully');
        }else{

            return redirect()->back()->with('error','Old Password Not Match Successfully');
        }

    }
}
