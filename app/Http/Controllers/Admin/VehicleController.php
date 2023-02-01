<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use Auth;

class VehicleController extends Controller
{
    public function index(){
        $vehicle = Vehicle::orderBy('id','desc')->get();
        $user = Auth::user()->name;
        return view('admin.vehicle.index', compact('vehicle','user'));
    }

    public function create(Request $request){
        Vehicle::create($request->all());
        return redirect()->back()->with('success','New Vehicle Added!');
    }

    public function update(Request $request){
        $vehicle = Vehicle::find($request->edit_id);
        $vehicle->update($request->all());
        return redirect()->back()->with('success','Vehicle Edited!');
    }

    public function delete(Request $request){
        $vehicle = Vehicle::find($request->delete_id);
        $vehicle->delete();
        return redirect()->back()->with('success','Vehicle Deleted!');

    }
}
