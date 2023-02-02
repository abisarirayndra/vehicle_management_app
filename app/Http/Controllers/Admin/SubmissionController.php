<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Vehicle;
use App\Models\Submission;
use App\Models\SubmissionGranted;
use Auth;

class SubmissionController extends Controller
{
    public function index(){
        $user = Auth::user()->name;
        $employee = Employee::all();
        $vehicle = Vehicle::select('id','merk','vehicle_number')->where('status', 0)->orderBy('merk','asc')->get();
        $submission = Submission::select('employees.employee_name','employees.position','vehicles.merk','vehicles.vehicle_number',
                                           'submissions.status','submissions.date_allowed','submissions.id','submissions.employee_id','submissions.vehicle_id')
                                    ->join('employees','employees.id','=','submissions.employee_id')
                                    ->join('vehicles','vehicles.id','=','submissions.vehicle_id')
                                    ->orderBy('id','desc')
                                    ->where('submissions.status', 0)
                                    ->orWhere('submissions.status', 1)
                                    ->get();
        return view('admin.submission.index', compact('employee','vehicle','submission','user'));
    }

    public function create(Request $request){
        $check = Submission::where('employee_id', $request->employee_id)->where('vehicle_id',$request->vehicle_id)->where('status', 0)->first();
        if($check){
            return redirect()->back()->with('errors','Your Submission Already Exsist!');
        }
        Submission::create([
            'employee_id' => $request->employee_id,
            'vehicle_id' => $request->vehicle_id,
            'status' => 0,
        ]);

        $book = Vehicle::find($request->vehicle_id);
        $book->update([
            'status' => 1,
        ]);

        return redirect()->route('admin.submission')->with('success','Submission Created!');
    }

    public function update(Request $request){
        $check = Submission::where('employee_id', $request->employee_id)->where('vehicle_id',$request->vehicle_id)->where('status', 0)->first();
        if($check){
            return redirect()->back()->with('errors','Your Submission Already Exsist!');
        }
        $submission = Submission::find($request->edit_id);
        $submission->update($request->all());
        return redirect()->route('admin.submission')->with('success','Submission Updated!');

    }

    public function delete(Request $request){
        $submission = Submission::find($request->delete_id);
        $submission->delete();
        return redirect()->route('admin.submission')->with('success','Submission Deleted!');

    }

    public function show($id){
        $user = Auth::user()->name;
        $track_subs = SubmissionGranted::join('submissions','submissions.id','=','submission_granteds.submission_id')
                                            ->join('employees','employees.id','=','submissions.employee_id')
                                            ->join('vehicles','vehicles.id','=','submissions.vehicle_id')
                                            ->join('users','users.id','=', 'submission_granteds.manager_id')
                                            ->select('employees.employee_name','employees.position','vehicles.merk','vehicles.vehicle_number',
                                                    'submission_granteds.status','submissions.id','users.name as manager','submission_granteds.created_at')
                                            ->where('submission_id', $id)
                                            ->orderBy('submission_granteds.id', 'desc')
                                            ->get();
        return view('admin.submission.show', compact('user','track_subs'));
    }

    public function return_submission(Request $request){
        $update_submission_granted = SubmissionGranted::where('submission_id', $request->submission_id)
                                                ->update([
                                                        'status' => 3,
                                                    ]);
        $update_submission = Submission::find($request->submission_id);
        $update_submission->update([
            'status' => 3,
            'date_allowed' => null,
        ]);
        $update_vehicle = Vehicle::find($update_submission->vehicle_id);
        $update_vehicle->update([
            'status' => 0,
        ]);

        return redirect()->route('admin.submission')->with('success','Return vehicle successfull');
    }

    public function history(Request $request){
        $user = Auth::user()->name;
        if($request->month){
            $submission = Submission::select('employees.employee_name','employees.position','vehicles.merk','vehicles.vehicle_number',
                                           'submissions.status','submissions.date_allowed','submissions.id','submissions.employee_id','submissions.vehicle_id','submissions.created_at')
                                    ->join('employees','employees.id','=','submissions.employee_id')
                                    ->join('vehicles','vehicles.id','=','submissions.vehicle_id')
                                    ->orderBy('id','desc')
                                    ->whereMonth('submissions.created_at', $request->month)
                                    ->whereYear('submissions.created_at', $request->year)
                                    ->where('submissions.status','!=', 0)
                                    ->get();
            return view('admin.submission.history', compact('user','submission'));
        }
        $submission = Submission::select('employees.employee_name','employees.position','vehicles.merk','vehicles.vehicle_number',
                                           'submissions.status','submissions.date_allowed','submissions.id','submissions.employee_id','submissions.vehicle_id', 'submissions.created_at')
                                    ->join('employees','employees.id','=','submissions.employee_id')
                                    ->join('vehicles','vehicles.id','=','submissions.vehicle_id')
                                    ->orderBy('id','desc')
                                    ->where('submissions.status', 1)
                                    ->orWhere('submissions.status', 2)
                                    ->orWhere('submissions.status', 3)
                                    ->get();

        return view('admin.submission.history', compact('user','submission'));
    }
}
