<?php

namespace App\Http\Controllers\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Social;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SocialController extends Controller
{
   public function __construct()
   {
       $this->middleware(['auth','isAdmin','Setting']);
   }
    public function index()
    {
        $data['page_title'] = "All Social";
        $data['socials'] = Social::latest()->get();
        return view('admin.setting.social.index',$data);
    }

    public function create()
    {
        $data['page_title'] = "New Social Create";
        return view('admin.setting.social.create',$data);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required|unique:socials,title',
            'link' => 'required|unique:socials,link',
            'code' => 'required|unique:socials,code',
        ]);
        try {
            DB::beginTransaction();

            $in = $request->all();
            $in['status'] = $request->status == 'on' ? '1' : '0';
            $in['slug'] = Str::slug($request->title);
            Social::create($in);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            //throw $e;
        }
        session()->flash('message','Social Create Successfully Done!');
        return redirect()->route('socials.index');
    }

    public function edit($id)
    {
        $data['page_title'] = "Edit Social";
        $data['social'] = Social::findOrFail($id);
        return view('admin.setting.social.edit',$data);
    }


    public function update(Request $request, $id)
    {
        $social = Social::findOrFail($id);
        $this->validate($request,[
            'title' => 'required|unique:socials,title,'.$social->id,
            'link' => 'required|unique:socials,link,'.$social->id,
            'code' => 'required|unique:socials,code,'.$social->id,
        ]);
        try {
            DB::beginTransaction();

            $in = $request->all();
            $in['status'] = $request->status == 'on' ? '1' : '0';
            $in['slug'] = Str::slug($request->title);
            $social->fill($in)->save();
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            //throw $e;
        }
        session()->flash('message','Social Update Successfully Done!');
        return redirect()->route('socials.index');
    }

    public function destroy($id)
    {
       $social = Social::findOrFail($id);
       $social->delete();
       session()->flash('message','Slider Delete Successfully Done!');
       return redirect()->back();
    }
}
