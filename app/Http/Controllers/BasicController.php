<?php

namespace App\Http\Controllers;

use App\BasicSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Mockery\Exception;

class BasicController extends Controller
{
    function __construct()
    {
        $this->middleware(['auth','isAdmin','Setting']);
    }

    public function index()
    {
        $data['page_title'] = "Basic Setting";
        $data['basic'] = BasicSetting::first();
        return view('admin.setting.basic-setting',$data);
    }

    public function update(Request $request)
    {
        $request->validate([
           'title' => 'required',
           'phone' => 'required',
           'email' => 'required',
           'address' => 'required',
        ]);
        try{
            $basic = BasicSetting::first();
            $in = $request->all();

            if ($request->hasFile('logo')){

                $request->validate(['logo' => 'nullable|mimes:png']);

                File::delete(public_path("logo.png"));
                $logo = $request->file('logo');
                $name = "logo".'.'.$logo->getClientOriginalExtension();
                $location = public_path($name);
                Image::make($logo)->resize(100,100)->save($location);
            }
            if ($request->hasFile('favicon')){

                $request->validate(['favicon' => 'nullable|mimes:png']);

                File::delete(public_path("favicon.png"));
                $logo = $request->file('favicon');
                $name = "favicon".'.'.$logo->getClientOriginalExtension();
                $location = public_path($name);
                Image::make($logo)->resize(100,100)->save($location);
            }
            $basic->update($in);
            session()->flash('message','Basic Website Setting Update Successfully.');
            return redirect()->back();

        }catch (Exception $e){
            session()->flash('error','Something Wrong.');
            return redirect()->back();
        }

    }

    public function indexCopy()
    {
        $data['page_title'] = "Copy Right";
        $data['basic'] = BasicSetting::first();
        return view('admin.setting.copy-setting',$data);
    }
    public function updateCopy(Request $request)
    {
        $request->validate(['copy' => 'required']);
        try {
            DB::beginTransaction();

            $basic = BasicSetting::first();
            $in = $request->all();
            $basic->update($in);

           DB::commit();
       } catch (\Throwable $e) {
            DB::rollback();
            //throw $e;
        }
        session()->flash('message','Copy Right Update Successfully Done!');
        return redirect()->back();
    }
    public function about()
    {
        $data['page_title'] = "About Update";
        $data['basic'] = BasicSetting::first();
        return view('admin.setting.about',$data);
    }
    public function aboutUpdate(Request $request)
    {
        $request->validate(['about' => 'required']);
        try {
            DB::beginTransaction();

            $basic = BasicSetting::first();
            $in = $request->all();
            $basic->update($in);

          DB::commit();
      } catch (\Throwable $e) {
            DB::rollback();
            //throw $e;
        }
        session()->flash('message','About Update Successfully Done!');
        return redirect()->back();
    }

    public function terms()
    {
        $data['page_title'] = "Terms & Condition Update";
        $data['basic'] = BasicSetting::first();
        return view('admin.setting.terms',$data);
    }
    public function termsUpdate(Request $request)
    {
        $request->validate(['terms' => 'required']);
        try {
            DB::beginTransaction();

            $basic = BasicSetting::first();
            $in = $request->all();
            $basic->update($in);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            //throw $e;
        }
        session()->flash('message','Terms & Condition Update Successfully Done!');
        return redirect()->back();
    }

    public function privacy()
    {
        $data['page_title'] = "Privacy Update";
        $data['basic'] = BasicSetting::first();
        return view('admin.setting.privacy',$data);
    }
    public function privacyUpdate(Request $request)
    {
        $request->validate(['privacy' => 'required']);
        try {
            DB::beginTransaction();

            $basic = BasicSetting::first();
            $in = $request->all();
            $basic->update($in);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            //throw $e;
        }
        session()->flash('message','Privacy Update Successfully Done!');
        return redirect()->back();
    }
}
