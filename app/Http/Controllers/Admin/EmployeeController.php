<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Auth;

class EmployeeController extends Controller
{
    public function index(){
        $employee = Employee::orderBy('id','desc')->get();
        $user = Auth::user()->name;
        return view('admin.employee.index', compact('employee','user'));
    }

    public function create(Request $request){
        Employee::create($request->all());
        return redirect()->back()->with('success','New Employee Added!');
    }

    public function update(Request $request){
        $employee = Employee::find($request->edit_id);
        $employee->update($request->all());
        return redirect()->back()->with('success','Employee Edited!');
    }

    public function delete(Request $request){
        $employee = Employee::find($request->delete_id);
        $employee->delete();
        return redirect()->back()->with('success','Employee Deleted!');

    }
}
