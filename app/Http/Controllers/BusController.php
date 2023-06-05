<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Illuminate\Http\Request;

class BusController extends Controller
{
    function __construct(){
        $this->middleware(['Setting','auth']);
    }

    public function index()
    {
        $data['page_title'] = "Bus List";
        $data['buses'] = Bus::latest()->get();
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
            'reg_last_date' => 'required|string',
        ]);

        if(!$valid){
            return response()->json();
        }
        $in = $request->all();
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
            ]);


            if(!$valid){
                return response()->json();
            }

            $in = $request->all();
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
        $buss->delete();
        session()->flash('message','Bus deleted successfully !!');
        return redirect()->back();
    }
}
