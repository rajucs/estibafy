<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\Helpers;
use App\Models\Job;
use App\Models\JobHelpers;
use App\Models\UserRoles;
use App\Events\FCMNotificationEvent;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psy\VersionUpdater\Checker;

class JobsController extends Controller
{

    private $database;

    public function __construct()
    {
        $this->database = \App\Services\FirebaseService::connect();
    }

    public function index(Request $request)
    {
        $data['jobs'] = Checkout::with('job.container', 'user')->get();
        // return $data;
        return view('jobs.index', $data);
    }

    public function job_detail($id)
    {
        $data['jobs'] = Job::with('user', 'checkout', 'job_helpers.helper_profile')->find($id);
        // return $data;
        return view('jobs.job_detail', $data);
    }
    public function job_status_by_admin(Request $request)
    {

        $job = Job::where('id', $request->job_id)->first();
        $job->job_status = $request->status;
        $job->job_comment = $request->job_comment;
        $job->update();


        if ($request->status == 'declined') {
            $status = 'declined';
        } else {
            $status = 'pending';
        }
        // $checkout  = Checkout::where('job_id', $request->job_id)->update([
        //     'status' => $status,
        // ]);

        // Retrieve the checkout data before updating
        $checkout = Checkout::where('job_id', $request->job_id)->first();

        // Check if the checkout data exists
        if ($checkout) {
            // Update the status
            $checkout->status = $status;

            // Save the changes
            $checkout->save();
        }

        $reciever = User::find($job->user_id);
        $jobdata['job'] = $job;
        $jobdata['checkout'] = $checkout;
        $this->database->getReference('company/job')
            ->set($jobdata);
        event(new FCMNotificationEvent("The job you created is '" . $request->status . "'" . $request->job_comment, "Job Status", "https://grid.gograph.com/driver-in-front-of-school-bus-vector-art_gg57726891.jpg", [$reciever]));


        return response()->json(['message' => 'Status updated successfully.']);
    }
    public function job_status(Request $request)
    {
        // return $request;
        $job_status = Job::find($request->job_id);
        $job_status->status = $request->value;
        $job_status->update();

        return response()->json(['message' => 'true']);
    }

    public function job_helper(Request $request)
    {
        // return $request;
        $user_role = UserRoles::find(Auth::user()->user_type);

        // return $user_role;
        if ($user_role->title == 'Super Admin') {
            $job_helper_status = JobHelpers::where('id', $request->user_id)->update([
                'job_comment_status' => $request->value,
                'approved_by' => 'admin',
            ]);
        } else {
            $job_helper_status = JobHelpers::where('id', $request->user_id)->update([
                'job_comment_status' => $request->value,
                'approved_by' => 'user',
            ]);
        }

        return response()->json(['message' => 'true']);
    }

    public function helper_profile($id)
    {
        $data['profile'] = Helpers::find($id);
        // return $data;
        return view('jobs.helper_profile', $data);
    }

    public function job_asset($id)
    {
        $job_asset = DB::table('job_helpsers')
            ->join('job_assets', 'job_helpsers.id', 'job_assets.job_helper_id')
            ->select('job_helpsers.id as job_id', 'job_helpsers.job_completion_status', 'job_assets.*')
            ->where('job_assets.job_helper_id', $id)
            ->get();

        // return $job_asset;
        return view('jobs.job_asset', compact('job_asset'));
    }

    public function job_asset_status($id)
    {
        $helper = JobHelpers::find($id);
        if ($helper->job_completion_status == '') {
            $helper->job_completion_status = 'approved';
            $helper->save();

            return redirect()->back()->with('success', 'Job Helper  active successfully!');
        } elseif ($helper->job_completion_status == 'approved') {
            $helper->job_completion_status = 'unapproved';
            $helper->save();

            return redirect()->back()->with('success', 'Job Helper Dective successfully!');
        } else {
            $helper->job_completion_status = 'approved';
            $helper->save();

            return redirect()->back()->with('success', 'Job Helper Active successfully!');
        }
    }
}
