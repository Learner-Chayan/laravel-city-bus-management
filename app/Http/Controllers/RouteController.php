<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\Stopage;
use Illuminate\Http\Request;

class RouteController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth','Setting']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = "Route List";
        $data['routes'] = Route::latest()->get();
        $data['stoppages'] = Stopage::where('status',1)->get();
        return view('admin.route.index',$data);
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
        $valid = $this->validate($request,[
            'name' => 'required|unique:routes,name',
            'stoppage_id.*' => 'required',
        ]);
        if (!$valid){
            return response()->json($valid);
        }
        $in = $request->except('stoppage_id');
        $stoppageId = $request->input('stoppage_id');
        $in['stoppage_id'] = json_encode($stoppageId,true);
//        $data = [];
//        foreach ($request->stoppage_id as $key => $stpId){
//            $data[] = [
//               'id_'.$key  => $stpId
//            ];
//
//        }
//        $in['stoppage_id'] =  json_encode($data);
        Route::create($in);
        return response()->json();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function show(Route $route)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function edit(Route $route)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Route $route)
    {
        //return $request;
        $route = Route::findOrFail($request->id);
        $valid = $this->validate($request,[
            'name' => 'required|unique:routes,name,'.$route->id,
           // 'stoppage_id.*' => 'required',
        ]);
        if (!$valid){
            return response()->json($valid);
        }

        $in = $request->except('stoppage_id');
        $stoppage_id = $request->input('stoppage_id');

        if($stoppage_id != null){
            $in["stoppage_id"] = json_encode($stoppage_id);
        }

        $route->fill($in)->save();
        return response()->json();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Route  $route
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Route $route)
    {
        //dd($request);
        $route = Route::findOrFail($request->id);
        $route->delete();

        session()->flash('message','Route deleted successfully');
        return redirect()->back();


    }
}
