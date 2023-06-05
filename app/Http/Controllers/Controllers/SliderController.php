<?php

namespace App\Http\Controllers\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class SliderController extends Controller
{
   public function __construct()
   {
       $this->middleware(['auth','isAdmin','Setting']);
   }
    public function index()
    {
        $data['page_title'] = "All Slider";
        $data['sliders'] = Slider::latest()->get();
        return view('admin.setting.slider.index',$data);
    }

    public function create()
    {
        $data['page_title'] = "New Slider Create";
        return view('admin.setting.slider.create',$data);
    }

    public function store(Request $request)
    {
       $this->validate($request,[
           'title' => 'required|unique:sliders,title',
           'image' => 'mimes:jpg,png,jpeg',
       ]);
        try {
            DB::beginTransaction();
            $in = $request->all();
            $in['status'] = $request->status == 'on' ? '1' : '0';

            if ($request->hasFile('image'))
            {
                $image = $request->file('image');
                $image_name = 'slider-'.rand('11','99').'.'.$image->getClientOriginalExtension();
                $location = public_path('images/slider').'/'.$image_name;
                Image::make($image)->resize(215,215)->save($location);
                $in['image'] = $image_name;
            }
            Slider::create($in);

            DB::commit();
       } catch (\Throwable $e) {
            DB::rollback();
            //throw $e;
        }
        session()->flash('message','Slider Create Successfully Done!');
        return redirect()->route('sliders.index');
    }


    public function edit($id)
    {
        $data['page_title'] = "Edit Slider";
        $data['slider'] = Slider::findOrFail($id);
        return view('admin.setting.slider.edit',$data);
    }

    public function update(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);
        $this->validate($request,[
            'title' => 'required|unique:sliders,title,'.$slider->id,
            'image' => 'mimes: jpg,jpeg,png',
        ]);
        try {
            DB::beginTransaction();
            $in = $request->all();
            $in['status'] = $request->status == 'on' ? '1' : '0';

            if ($request->hasFile('image'))
            {
                File::delete(public_path('images/slider/'.$slider->image));
                $image = $request->file('image');
                $image_name = 'slider-'.rand('11','99').'.'.$image->getClientOriginalExtension();
                $location = public_path('images/slider').'/'.$image_name;
                Image::make($image)->resize(215,215)->save($location);
                $in['image'] = $image_name;
            }

            $slider->fill($in)->save();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            //throw $e;
        }
        session()->flash('message','Slider Update Successfully Done!');
        return redirect()->route('sliders.index');
    }

    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        File::delete(public_path('images/slider/'.$slider->image));
        $slider->delete();
        session()->flash('message','Slider Delete Successfully Done!');
        return redirect()->back();
    }
}
