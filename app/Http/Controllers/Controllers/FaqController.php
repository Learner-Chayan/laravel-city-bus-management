<?php

namespace App\Http\Controllers\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class FaqController extends Controller
{
     public function __construct()
     {
         $this->middleware(['auth','isAdmin','Setting']);
     }
    public function index()
    {
        $data['page_title'] = "All FAQ";
        $data['faqs'] = Faq::latest()->get();
        return view('admin.setting.faq.index',$data);
    }

    public function create()
    {
        $data['page_title'] = "New FAQ Create";
        return view('admin.setting.faq.create',$data);
    }


    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required|unique:faqs,title',
            'description' => 'required',
        ]);
        try {
            DB::beginTransaction();

            $in = $request->all();
            $in['status'] = $request->status == 'on' ? '1' : '0';
            Faq::create($in);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            //throw $e;
        }
        session()->flash('success','FAQ Create Successfully Done!');
        return redirect()->route('faqs.index');
    }


    public function edit($id)
    {
        $data['page_title'] = "All FAQ";
        $data['faq'] = Faq::findOrFail($id);
        return view('admin.setting.faq.edit',$data);
    }


    public function update(Request $request, $id)
    {
        $faq = Faq::findOrFail($id);
        $this->validate($request,[
            'title' => 'required|unique:faqs,title,'.$faq->id,
            'description' => 'required',
        ]);
        try {
            DB::beginTransaction();

            $in = $request->all();
            $in['status'] = $request->status == 'on' ? '1' : '0';
            $faq->fill($in)->save();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            //throw $e;
        }
        session()->flash('success','FAQ Update Successfully Done!');
        return redirect()->route('faqs.index');
    }

    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();
        session()->flash('success','FAQ Delete Successfully Done!');
        return redirect()->back();
    }


    public function indexAdvertisement ()
    {
        $data['page_title'] = "Advertisement";
        $data['advertisement'] = Advertisement::latest()->get();
        return view('admin.advertisement.index',$data);
    }
    public function createAdvertisement ()
    {
        $data['page_title'] = "New Advertisement";
        return view('admin.advertisement.create',$data);

    }
    public function storeAdvertisement(Request $request)
    {

        $this->validate($request,[

            'advert_type' => 'required',
            'advert_size' => 'required',
            'title'       => 'required',
            'val1'        => 'mimes:png,jpg,jpeg,gif'
        ]);

        try {
            DB::beginTransaction();

            $in = $request->except('_method','_token');
            $in['status'] = $request->status == 'on' ? '1' : '0';

            if ($request->hasFile('val1'))
            {
                $image = $request->file('val1');
                $image_name = "advert".rand('00000','199999').'.'.$image->getClientOriginalExtension();
                $location = public_path('images/ad').'/'.$image_name;
                Image::make($image)->save($location);
                $in['val1'] = $image_name;
            }

            Advertisement::create($in);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            //throw $e;
        }

        session()->flash('success','Advertisement Created Successfully Done!');
        return redirect()->route('advertisement');
    }
    public function editAdvertisement ($id)
    {
        $data['page_title'] = "Edit Advertisement";
        $data['advert'] = Advertisement::findOrFail($id);
        return view('admin.advertisement.edit',$data);
    }

    public function updateAdvertisement(Request $request)
    {
        $ad = Advertisement::findOrFail($request->id);
        $this->validate($request,[

            'advert_size' => 'required',
            'title'       => 'required',
            'val1'        => 'mimes:png,jpg,jpeg,gif'
        ]);

        try {
            DB::beginTransaction();

            $in = $request->except('_method','_token');
            $in['status'] = $request->status == 'on' ? '1' : '0';

            if ($request->hasFile('val1'))
            {
                File::delete(public_path('images/add/').$ad->val1);
                $image = $request->file('val1');
                $image_name = "advert".rand('00000','199999').'.'.$image->getClientOriginalExtension();
                $location = public_path('images/ad').'/'.$image_name;
                Image::make($image)->save($location);
                $in['val1'] = $image_name;
            }

            $ad->fill($in)->save();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            //throw $e;
        }

        session()->flash('success', 'Advertisement Successfully Update');
        return redirect()->route('advertisement');
    }

    public function deleteAdvertisement(Request $request)
    {
        dd($request->id);
    }
}
