<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Vehicle;
use App\Models\Employee;
use App\Models\Submission;
use DB;

class AdminController extends Controller
{
    public function dashboard(){
        $user = Auth::user()->name;
        $vehicle = Vehicle::count();
        $vehicle_available = Vehicle::where('status', 0)->count();
        $employee = Employee::count();
        $granted_subs = Submission::where('status', 1)->count();
        $denied_subs = Submission::where('status', 2)->count();
        $returned_subs = Submission::where('status', 3)->count();
        $on_process = Submission::where('status', 0)->count();

        $submission = Submission::select(DB::raw('COUNT(submissions.vehicle_id) as total_usage'), DB::raw('MONTH(submissions.created_at) as month'))
                                    ->where('submissions.status', 1)
                                    ->orWhere('submissions.status', 3)
                                    ->groupBy('month')
                                    ->get();
                                    // return $submission;
        $categories = [];
        $data = [];

        foreach ($submission as $item) {
            $categories[] = $item->month;
            $data[] = (int) $item->total_usage;
        }
        // return $categories;
        return view('admin.admin_dashboard', compact('user','vehicle_available','vehicle','employee','granted_subs','denied_subs',
                                                'returned_subs','on_process','data','categories'));
    }
}
