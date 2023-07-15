<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class BusController extends Controller
{
    function __construct(){
        $this->middleware(['Setting','auth','role:admin|customer|employee|owner']);
    }

    public function index()
    {
        $data['page_title'] = "Bus List";
        $user = Auth::user();
        if ($user->hasRole('admin'))
        {
            $data['buses'] = Bus::with('owner')->latest()->get();

        }else{
            $data['buses'] = Bus::with('owner')->where('owner_id',$user->id)->latest()->get();

        }
        $data['owners'] = User::where('customer_type',2)->latest()->get();
        return view('admin.bus.index',$data);
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
        $valid =  $this->validate($request,[
            'name' => 'required|string|unique:buses,name',
            'reg_number' => 'required|string|unique:buses,reg_number',
            'coach_number' => 'required|numeric|unique:buses,coach_number',
            'reg_last_date' => 'required|string',
            'owner_id' => 'required',
            'seat_number' => 'required|numeric',
        ]);

        if(!$valid){
            return response()->json();
        }
        $in = $request->all();
        $in['owner_id'] = $request->owner_id;
        if ($request->hasFile('reg_image'))
        {
            $file = $request->file('reg_image');
            $fileName = uniqid().'.'.$file->getClientOriginalExtension();
            Image::make($file)->save(public_path("images/bus/$fileName"));
            $in['reg_image'] = $fileName;
        }
        Bus::create($in);
        return response()->json();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bus  $bus
     * @return \Illuminate\Http\Response
     */
    public function show(Bus $bus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bus  $bus
     * @return \Illuminate\Http\Response
     */
    public function edit(Bus $bus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bus  $bus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
//        return response()->json($request->all());
          $bus = Bus::findOrFail($request->id);

            $valid = $this->validate($request,[
                'name' => 'required|string|unique:buses,name,'.$bus->id,
                'reg_number' => 'required|string|unique:buses,reg_number,'.$bus->id,
                'reg_last_date' => 'required|string',
                'seat_number' => 'required|numeric',
                'owner_id' => 'required',
                'coach_number' => 'required|numeric|unique:buses,coach_number,'.$bus->id,


            ]);


            if(!$valid){
                return response()->json();
            }

            $in = $request->all();
            $in['owner_id'] = $request->owner_id ;
            if ($request->hasFile('reg_image'))
            {
                File::delete(public_path("images/bus/$bus->reg_image"));
                $file = $request->file('reg_image');
                $fileName = uniqid().'.'.$file->getClientOriginalExtension();
                Image::make($file)->save(public_path("images/bus/$fileName"));
                $in['reg_image'] = $fileName;
            }
            $bus->fill($in)->save();
            return $bus;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bus  $bus
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $buss = Bus::findOrFail($id);
        File::delete(public_path("images/bus/$buss->reg_image"));
        $buss->delete();
        session()->flash('message','Bus deleted successfully !!');
        return redirect()->back();
    }
}
