<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\Helpers;
use App\Models\Job;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Events\FCMNotificationEvent;

class DashboardController extends Controller
{
    public function index()
    {

        // $jobs =  Checkout::with('job', 'job.job_helpers', 'job.user', 'job.user.company')->where(['status' => 'pending'])->orderBy('id', 'DESC')->get();
        // foreach ($jobs as $job) {
        //     $job_helpers = $job->total_helpers;
        //     $accpted_helper = count($job->job->job_helpers) - 1;
        //     if ($accpted_helper < $job_helpers) {
        //         $reciever = User::find($job->user_id);
        //         $start_date_time = strtotime($job->job->start_time);
        //         $current_date_time = time();
        //         // echo date('Y-m-d H:i:s',$start_date_time);
        //         // echo "<br>";
        //         // echo date('Y-m-d H:i:s',$current_date_time);
        //         $total_time = ($current_date_time - $start_date_time)/(60); //add 3600 instead 60 if hour difference
        //         // dd($total_time);
        //         if ($total_time > 45 && $reciever) {
        //             event(new FCMNotificationEvent("The Job '" . $job->name . "'" . " Is not with enough helper if you want to continue.....", "Job Pending", "https://grid.gograph.com/driver-in-front-of-school-bus-vector-art_gg57726891.jpg", [$reciever]));
        //         }
        //     }
        // }
    
        $data['jobss']   = Job::all()->count();
        $data['users']   = User::where('user_type', 3)->count();
        $data['companies']   = User::where('user_type', 2)->count();
        $data['helpers']   = Helpers::all()->count();
        $data['complete']   = Checkout::with('job', 'job.container')->where('status', 'complete')->get()->count();
        $data['inprogress'] = Checkout::with('job', 'job.container')->where('status', 'inprocess')->get()->count();
        $data['pending']    = Checkout::with('job', 'job.container')->where('status', 'pending')->get()->count();
        $data['earning']   = Checkout::with('job', 'job.container')->where('status', 'complete')->get()->sum('total');
        $data['jobs'] = Checkout::with('job.user', 'job.container')->get();
        // return $data;
        return view('dashboard', $data);
    }


    /*logoutUser*/
    public function sign_out()
    {

        Auth::logout();

        Session::flush();
        $message = "Successfully logged OUT...";
        session::flash('success_message', $message);

        return redirect('/');
    }

    /*Blank*/
    public function Blank()
    {
        return view('Sample/BlankSample');
    }

    /*DataTableSample*/
    public function DataTableSample()
    {
        return view('Sample/table-sample');
    }

    /*DataTableSample*/
    public function FormValidationSample()
    {
        return view('Sample/form-validation-sample');
    }
}
