<?php

namespace App\Http\Controllers;

use App\Models\Stopage;
use Illuminate\Http\Request;

class StopageController extends Controller
{
     function __construct(){
        $this->middleware(['Setting','auth']);
    }
    public function index(){
        $data['page_title'] = "Stoppage List";
        $data['stoppages'] = Stopage::latest()->get();
        return view('admin.stoppage.index',$data);
    }

    public function Store(Request $request){
        $valid =  $this->validate($request,[
            'name' => 'required|string|unique:stopages,name',
        ]);

        if(!$valid){
            return response()->json();
        }
        $in = $request->all();
        $in['status'] = 1;
        Stopage::create($in);
        return response()->json();

        //return redirect()->back()->with('message','Successfully Create Stoppage');

    }
    public function edit(Stopage $stopage)
    {
        $stoppage = Stopage::findOrFail($stopage->id);
        return response()->json($stoppage);
    }
    public function update(Request $request){
        $stoppage = Stopage::findOrFail($request->id);
        $valid = $this->validate($request,[
            'name' => 'required|string|unique:stopages,name,'.$stoppage->id,
        ]);
 

        if(!$valid){
            return response()->json();
        }

        $in = $request->all();
        $stoppage->fill($in)->save();
        return;
    }

    public function destroy($id){
        $stoppage = Stopage::findOrFail($id);
        $stoppage->delete();
        
        session()->flash('message','Stoppage deleted successfully !!');
        return redirect()->back();
    }
}
