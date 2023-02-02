<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Submission;
use App\Models\Vehicle;
use App\Models\SubmissionGranted;
use Auth;
use Carbon\Carbon;

class SubmissionController extends Controller
{
    public function index(){
        $user = Auth::user()->name;
        $submission = Submission::select('employees.employee_name','employees.position','vehicles.merk','vehicles.vehicle_number',
                                           'submissions.status','submissions.date_allowed','submissions.id','submissions.employee_id','submissions.vehicle_id')
                                    ->join('employees','employees.id','=','submissions.employee_id')
                                    ->join('vehicles','vehicles.id','=','submissions.vehicle_id')
                                    ->orderBy('id','desc')
                                    ->where('submissions.status', 0)
                                    ->orWhere('submissions.status', 1)
                                    ->get();
        return view('manager.submission.index', compact('submission','user'));
    }

    public function action_submission(Request $request){
        $already_action = SubmissionGranted::where('submission_id', $request->submission_id)->where('manager_id', Auth::user()->id)->first();
        if($already_action){
            return redirect()->back()->with('errors','Already make action to this submission!');
        }
        SubmissionGranted::create([
            'submission_id' => $request->submission_id,
            'manager_id' => Auth::user()->id,
            'status' => $request->status,
        ]);
        $total_granted = SubmissionGranted::where('submission_id', $request->submission_id)->where('status', 1)->count();
        $total_denied = SubmissionGranted::where('submission_id', $request->submission_id)->where('status', 2)->count();

        if($total_granted == 3){
            $update_submission = Submission::find($request->submission_id);
            $update_submission->update([
                'status' => 1,
                'date_allowed' => Carbon::now(),
            ]);
            $update_vehicle = Vehicle::find($update_submission->vehicle_id);
            $update_vehicle->update([
                'status' => 1,
            ]);
            return redirect()->route('manager.submission')->with('success','Submission Granted!');
        }elseif($total_denied == 3){
            $update_submission = Submission::find($request->submission_id);
            $update_submission->update([
                'status' => 2,
            ]);
            $update_vehicle = Vehicle::find($update_submission->vehicle_id);
            $update_vehicle->update([
                'status' => 0,
            ]);
            return redirect()->route('manager.submission')->with('success','Submission Denied!');
        }

        if($request->status == 1){
            return redirect()->route('manager.submission.granted')->with('success','Submission Granted!');
        }elseif($request->status == 2){
            return redirect()->route('manager.submission.denied')->with('success','Submission Denied!');
        }
    }

    public function granted_submission(){
        $user = Auth::user()->name;
        $me = Auth::user()->id;
        $granted = SubmissionGranted::join('submissions','submissions.id','=','submission_granteds.submission_id')
                            ->join('employees','employees.id','=','submissions.employee_id')
                            ->join('vehicles','vehicles.id','=','submissions.vehicle_id')
                            ->select('employees.employee_name','employees.position','vehicles.merk','vehicles.vehicle_number',
                                    'submission_granteds.status','submissions.id')
                            ->where('manager_id', $me)
                            ->where('submission_granteds.status', 1)
                            ->get();

        return view('manager.submission.granted', compact('user','granted'));
    }

    public function denied_submission(){
        $user = Auth::user()->name;
        $me = Auth::user()->id;
        $granted = SubmissionGranted::join('submissions','submissions.id','=','submission_granteds.submission_id')
                            ->join('employees','employees.id','=','submissions.employee_id')
                            ->join('vehicles','vehicles.id','=','submissions.vehicle_id')
                            ->select('employees.employee_name','employees.position','vehicles.merk','vehicles.vehicle_number',
                                    'submission_granteds.status','submissions.id')
                            ->where('manager_id', $me)
                            ->where('submission_granteds.status', 2)
                            ->get();

        return view('manager.submission.granted', compact('user','granted'));
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
        return view('manager.submission.show', compact('user','track_subs'));
    }

    public function history(){
        $user = Auth::user()->name;
        $submission = Submission::select('employees.employee_name','employees.position','vehicles.merk','vehicles.vehicle_number',
                                           'submissions.status','submissions.date_allowed','submissions.id','submissions.employee_id','submissions.vehicle_id', 'submissions.created_at')
                                    ->join('employees','employees.id','=','submissions.employee_id')
                                    ->join('vehicles','vehicles.id','=','submissions.vehicle_id')
                                    ->orderBy('id','desc')
                                    ->where('submissions.status', 1)
                                    ->orWhere('submissions.status', 2)
                                    ->orWhere('submissions.status', 3)
                                    ->get();

        return view('manager.submission.history', compact('user','submission'));
    }
}
