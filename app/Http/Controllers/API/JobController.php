<?php

namespace App\Http\Controllers\API;

use App\Events\createJobsEvent;
use App\Events\FCMNotificationEvent;
use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\BaseFire;
use App\Models\Checkout;
use App\Models\Companies;
use App\Models\CompaniesWallet;
use App\Models\Container;
use App\Models\Helpers;
use App\Models\Package;
use App\Models\Job;
use App\Models\JobAssets;
use App\Models\JobHelperGeoData;
use App\Models\JobHelpers;
use App\Models\PaymentMehodCred;
use App\Models\Tax;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;


use App\Models\User;


use Session;
use Hash;
use DataTables;
use Mail;
use PDF;
use DB;
use Carbon\Carbon;
use DateTime;

class JobController extends Controller
{

    private $database;

    public function __construct()
    {
        $this->database = \App\Services\FirebaseService::connect();
    }


    public function package_types(Request $request)
    {
        $response['success'] = 200;
        $response['message'] = '';
        $response['error'] = [];
        $response['data'] = [
            'package_types' =>  Package::select('id', 'name')->where('status', 1)->get(),
            'container_types' => Container::select('id', 'name', 'type', 'helper_size')->where('status', 1)->get()
        ];
        return response()->json($response);
    }
    public function job_post(Request $request)
    {
        $rules = array(
            'name' => 'required',
            'container_id' => 'required',
            'package_type' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array(
                'success' => 400,
                'error' => $validator->errors(),
                'message' => '',
                'data' => [],
            ));
        }

        // if ($request->file('image')) {
        //     $file = $request->file('image');
        //     $image = time() . '_' . $file->getClientOriginalName();
        //     $file->move('uploads',  $image);
        // }
        // if ($request->file('voice')) {
        //     $file2 = $request->file('voice');
        //     $voice = time() . '_' . $file2->getClientOriginalName();
        //     $file2->move('uploads/voice',  $voice);
        // }
        $job = Job::create([
            'name' => $request->name,
            'container_id' => $request->container_id,
            'package_type' => $request->package_type,
            'start_time' =>  Carbon::parse($request->start_time),
            'end_time' =>     Carbon::parse($request->end_time),
            'address' =>   $request->address,
            'user_id' =>   $request->user()->id,

            'latitude' =>   $request->latitude,
            'longitude' =>   $request->longitude,
        ]);

        if ($job) {
            $base = BaseFire::first();
            $payment_method = PaymentMehodCred::where([
                'stackholder_type' => 'user',
                'stackholder_id' => $request->user()->id
            ])->get();


            $helper_size_obj = Container::find($request->container_id);
            $helper_size =  $helper_size_obj->helper_size;



            // $sub_total  = $request->helper_size *  $base->base_fare;
            // $tax_rate   = 14;
            // $tax        = ($sub_total / 100) * $tax_rate;
            // $total      = $tax + $sub_total;

            // $checkout = Checkout::create([
            //     'job_id' =>  $job->id,
            //     'total' =>    $total,
            //     'tax' => $tax,
            //     'tax_rate' =>     $tax_rate,
            //     'sub_total' =>   $sub_total,
            //     'user_id' =>   $request->user()->id,
            //     'base_fare' =>   $base->base_fare,
            //     'days' =>   '2',
            //     'total_helpers' => $request->helper_size
            // ]);

            $reciever = Helpers::all();
            event(new FCMNotificationEvent("New job '" . $request->name . "'" . " was created just now! Tap for more details", "New Job Posted", "https://grid.gograph.com/driver-in-front-of-school-bus-vector-art_gg57726891.jpg", [$reciever]));

            // event(new createJobsEvent($reciever));

            return response()->json(array(
                'success' => 200,
                'job_id' => $job->id,
                'suggest_helper' => $helper_size,
                'base_fare' =>  $base->base_fare,
                'payment_method' =>  $payment_method,
                'job_detail' =>  $job,
                // 'checkout_detail' => $checkout
            ));
        }
    }

    public function job_summary(Request $request)
    {
        $rules = array(
            'container_id' => 'required',
            'package_type' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'address' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'voice' => 'max:2048',
            'helpers' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array(
                'success' => 400,
                'error' => $validator->errors(),
                'message' => '',
                'data' => [],
            ));
        }
        $datetime1 = new DateTime($request->start_time);
        $datetime2 = new DateTime($request->end_time);
        $interval = $datetime1->diff($datetime2);

        $base_fare  =   25;
        $days = ($interval->d + 1); //diffrence time
        $base_fare  = $base_fare  *  $days;
        $sub_total  = $request->helpers *  $base_fare;

        $tax_rate   = Tax::first()->tax_percentage;

        $tax        = ($sub_total / 100) * $tax_rate;
        $total      = $tax + $sub_total;

        $response['success'] = 200;
        $response['message'] = '';
        $response['error'] = [];
        $response['data'] = [
            'start_time' =>   $request->start_time,
            'end_time' =>  $request->end_time,
            'address' =>   $request->address,
            'packings_name' =>  Package::whereIn('id', explode(',',  $request->package_type))->pluck('name'),
            'container_size' =>  Container::select('id', 'name', 'size')->find($request->container_id),
            'charges' => [
                'base_fare' => '$' . $base_fare,
                'helpers' => $request->helpers,
                'sub_total' => $sub_total,
                'tax' => '$' . $tax,
                'days' => $days,
                'tax_rate' => $tax_rate . '%',
                'total' => '$' .   $total,
            ],
            'job_detail' =>  $request->all(),
        ];
        return response()->json($response);
    }

    public function job_checkout(Request $request)
    {

        $rules = array(
            'job_id'        => 'required',
            'total_helpers' => 'required',
            'payement_method' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(array(
                'success'   => 400,
                'error'     => $validator->errors(),
                'message'   => '',
                'data'      => [],
            ));
        }

        $datetime1 = new DateTime($request->start_time);
        $datetime2 = new DateTime($request->end_time);
        $interval = $datetime1->diff($datetime2);

        $base = BaseFire::first();
        //    $base_fare  =   25;
        $days = ($interval->d + 1); //diffrence time
        $base_fare  = $base->base_fare  *  $days;
        $sub_total  = $request->total_helpers *  $base->base_fare;

        $tax_rate   = Tax::first()->tax_percentage;

        $tax        = ($sub_total / 100) * $tax_rate;
        $total      = $tax + $sub_total;
        $payement_method = $request->payement_method;

        if ($payement_method == 0) {
            $payement_method = 'postpaid';
            $payment_status  = 'pending';
            $job_status      = 'inreview';
        } else {
            $job_status      = 'pending';
            $payement_method = 'card';
        }
        $payment_days = User::find($request->user()->id)->payment_days;
        // dd($payment_days);
        $checkout = Checkout::create([
            'job_id'            => $request->job_id,
            'total'             => $total,
            'tax'               => $tax,
            'tax_rate'          => $tax_rate,
            'sub_total'         => $sub_total,
            'user_id'           => $request->user()->id,
            'base_fare'         => $base_fare,
            'days'              => $days,
            'total_helpers'     => $request->total_helpers,
            'status'            => $job_status,
            'payement_method'   => $payement_method,
            'payment_status'    => $payment_status,
            'payment_days'      => $payment_days
        ]);

        $response['success'] = 200;
        $response['data'] = [
            'order_id'      => $checkout->id,
            'job_detail'    =>  $checkout::with('job')->where('id', $checkout->id)->first(),

        ];

        $reciever = Helpers::all();
        event(new FCMNotificationEvent("New job '" . $request->name . "'" . " was created just now! Tap for more details", "New Job Posted", "https://grid.gograph.com/driver-in-front-of-school-bus-vector-art_gg57726891.jpg", $reciever));

        return response()->json($response);
    }

    public function get_jobs(Request $request)
    {
        // $job_helper_location = JobHelperGeoData::where(['helpers_id' => 8])->where('job_id', 13)->get();
        // dd($job_helper_location);
        // dd($request->user()->id);
        $jobs = Job::with('checkout', 'container')->where('user_id', $request->user()->id)->get();
        $Checkout = [];
        $Checkout['complete']   = Checkout::with('job', 'job.container')->where(['user_id' => $request->user()->id, 'status' => 'complete'])->get();
        $Checkout['inprogress'] = Checkout::with('job', 'job.container')->where(['user_id' => $request->user()->id, 'status' => 'inprogress'])->get();
        $Checkout['pending']    = Checkout::with('job', 'job.container')->where(['user_id' => $request->user()->id, 'status' => 'pending'])->get();
        $Checkout['declined']    = Checkout::with('job', 'job.container')->where(['user_id' => $request->user()->id, 'status' => 'declined'])->get();
        $Checkout['inreview']    = Checkout::with('job', 'job.container')->where(['user_id' => $request->user()->id, 'status' => 'inreview'])->get();
        $response['success'] = 200;
        $response['message'] = '';
        $response['error'] = [];
        $response['data'] =     $Checkout;
        // $response['data']=     $jobs ;
        return response()->json($response);
    }

    public function confirm(Request $request)
    {
        $data['order_id'] = 1233131;
        $response['success'] = 200;
        $response['message'] = 'you will see your helpers on next screen or anytime from the manu.';
        $response['error'] = [];
        $response['data'] =    $data;
        // $response['data']=     $jobs ;
        return response()->json($response);
    }

    public function JobDetail(Request $request, $id)
    {
        $data =  Job::with('checkout', 'job_helpers.helper_profile')->find($id);
        return response()->json([
            'statusCode' => 200,
            'msg' => 'success',
            'data' => $data,
        ]);
    }

    public function jobhelperstatus(Request $request)
    {
        $rules = array(
            'status' => 'required',
            'job_id' => 'required'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array(
                'success' => 400,
                'error' => $validator->errors(),
                'message' => '',
            ));
        }
        $data = JobHelpers::where([
            'helper_id' => $request->helper_id,
            'job_id' => $request->job_id,
            'user_id' => $request->user()->id,
        ])->first();

        // if ($data) {
        //     $checkout = Checkout::where('job_id', $request->job_id);
        //     $checkout->forceFill([
        //         'total_join_helpers' => 0,
        //     ]);
        // }

        //         return $data;

        if (!$data) {
            return [
                'status_code' => 404,
                'msg' => "Data Not Found",
            ];
        }
        if ($request->status == 'accepted') {
            $data->forceFill([
                'job_comment_status' => $request->status,
            ]);
            $data->update();

            $job_id = $request->job_id;


            return response()->json([
                'status_code' => 200,
                'msg' => true,
            ]);
        } elseif ($request->status == 'decline') {
            $data->forceFill([
                'job_comment_status' => $request->status,
            ]);
            $data->update();

            return response()->json([
                'status_code' => 200,
                'msg' => true,
            ]);
        }
    }

    public function alljobs(Request $request)
    {
        $jobs = Checkout::where('status', 'pending')->with('job')->get();
        return response()->json([
            'status_code' => 200,
            'data' => $jobs,
        ]);
    }

    public function setJobGeoData(Request $request)
    {
        // dd($request);
        $data = Job::where([
            'id' => $request->job_id,
        ])->first();

        if (!$data) {
            return [
                'status_code' => 404,
                'msg' => "Data Not Found",
            ];
        }
        $data->forceFill([
            'latitude' => $request->lat,
            'longitude' => $request->lng
        ]);
        $data->update();

        $job_id = $request->job_id;


        return response()->json([
            'status_code' => 200,
            'msg' => true,
        ]);
    }

    public function getJobGeoData()
    {
    }
    public function userInvoices(Request $request)
    {
        $user_id = $request->user()->id;
        $Checkouts    = Checkout::with('job', 'job.container', 'job.job_helpers.helper_profile', 'user', 'user.company')->where('status', 'complete')->where(['user_id' => $user_id])->get();

        $response['success'] = 200;
        $response['message'] = '';
        $response['error'] = [];
        $response['data'] =     $Checkouts;
        // $response['data']=     $jobs ;
        return response()->json($response);
    }
    public function account_deletation(Request $request)
    {
        $request->user()->delete();
        $account_delation = 'Your account deleted successfully.';
        return response()->json([
            'status_code' => 200,
            'data' => $account_delation,
        ]);
    }

    public function companyJobs(Request $request)
    {
        $Checkout = [];
        $Checkout['inreview']    = Checkout::with('job', 'job.container', 'job.user', 'job.job_helpers', 'job.job_helpers.helper_profile')->where('status', 'inreview')->get();
        $Checkout['complete']    = Checkout::with('job', 'job.container', 'job.user', 'job.job_helpers', 'job.job_helpers.helper_profile')->where(['company_id' => $request->user()->id, 'status' => 'complete'])->get();
        $Checkout['inprogress']  = Checkout::with('job', 'job.container', 'job.user', 'job.job_helpers', 'job.job_helpers.helper_profile')->where(['company_id' => $request->user()->id, 'status' => 'inprogress'])->get();
        $Checkout['pending']     = Checkout::with('job', 'job.container', 'job.user', 'job.job_helpers', 'job.job_helpers.helper_profile')->where(['company_id' => $request->user()->id, 'status' => 'pending'])->get();
        $Checkout['declined']    = Checkout::with('job', 'job.container', 'job.user', 'job.job_helpers', 'job.job_helpers.helper_profile')->where(['company_id' => $request->user()->id, 'status' => 'declined'])->get();
        $Checkout['accepted']    = Checkout::with('job', 'job.container', 'job.user', 'job.job_helpers', 'job.job_helpers.helper_profile')->where(['company_id' => $request->user()->id, 'status' => 'accepted'])->get();
        $response['success'] = 200;
        $response['message'] = '';
        $response['error'] = [];
        $response['data'] =     $Checkout;
        // $response['data']=     $jobs ;
        return response()->json($response);
    }
    //company job accept

    public function companyJobAccept(Request $request)
    {


        // $this->database
        //     ->getReference('company/jobaccept')
        //     ->push([
        //         'title' => 'new job accept2',
        //         'content' => 'new job content2'
        //     ]);

        // return response()->json('blog has been created');


        $user = $request->user();
        // Validate the request data
        $request->validate([
            'job_id' => 'required',
            'status' => 'required',
        ]);

        $job_id = $request->job_id;
        // Retrieve the record to update
        $checkout = Checkout::where('job_id', $job_id)
            // ->where('company_id', $user->id)
            ->first();

        if ($checkout) {
            $job_entry = Job::find($job_id);
            $reciever = User::find($job_entry->user_id);
            $jobdata['job'] = $job_entry;
            $jobdata['checkout'] = $checkout;
            // Check if the current status is not "accepted"
            // dd($reciever);
            if ($checkout->status !== 'accepted') {
                // Update the status
                $checkout->update([
                    'company_id' => $user->id,
                    'status' => $request->status,
                ]);
                $this->database
                    ->getReference('company/jobaccept')
                    ->push([
                        'data' => $jobdata
                    ]);
                // Send a notification event if the status is updated to "accepted"
                event(new FCMNotificationEvent("The Job '" . $job_entry->name . "'" . " was accepted just now! Tap for more details", "Job Accepted", "https://grid.gograph.com/driver-in-front-of-school-bus-vector-art_gg57726891.jpg", [$reciever]));

                // Return a success response
                return response()->json(['message' => 'Job Accepted', 'status_code' => 200, 'data' => $jobdata]);
            } else {
                // If the current status is already "accepted," return a message indicating that
                return response()->json(['message' => 'This Job is already accepted', 'status_code' => 200, 'data' => $jobdata]);
            }
        } else {
            // Record not found, return an error response
            return response()->json(['message' => 'No job found', 'status_code' => 400]);
        }
    }
    public function companyHelpersAssign(Request $request)
    {
        try {
            $helpers = json_decode($request->helpers);
            $job_obj = Checkout::where('job_id', $request->job_id)->where('company_id', $request->user()->id)->first();
            if (!$job_obj) {
                return response()->json([
                    'status_code' => 404,
                    'msg' => 'Job not found',
                ]);
            }
            foreach ($helpers as $helper) {
                $data = JobHelpers::where(['helper_id' => $helper, 'job_id' => $request->job_id])->first();
                if (!$data) {
                    $user_id = $job_obj->user_id;
                    $job_id =  $request->job_id;
                    $status = $request->status;
                    $job_comment_status = 'accepted';

                    $jh = new JobHelpers();
                    $jh->job_id = $job_id;
                    $jh->user_id = $user_id;
                    $jh->helper_id = $helper;
                    $jh->status = $status;
                    $jh->job_comment_status = $job_comment_status;
                    $jh->approved_by = 'system';
                    $jh->save();

                    $job_entry = Job::find($job_id);
                    $reciever = Helpers::find($helper);

                    event(new FCMNotificationEvent("The Job '" . $job_entry->name . "'" . " was Assigned to you just now! Tap for more details", "Job Assigned", "https://grid.gograph.com/driver-in-front-of-school-bus-vector-art_gg57726891.jpg", [$reciever]));
                } else {
                    return response()->json([
                        'status_code' => 200,
                        'msg' => 'One of helper Already added for this job',
                    ]);
                    break;
                }
            }
            //edit by arman
            $all_helper_jobs = JobHelpers::where([
                ['job_id', '=', $job_obj->job_id],
                ['status', '=', 'inprocess']
            ])->get();
            // dd($all_helper_jobs);

            // $job_data = Checkout::where('job_id', '=', $request->job_id)->first();
            $total_helper_job = count($all_helper_jobs);
            $total_job_helper = $job_obj->total_helpers;
            if ($total_helper_job == $total_job_helper) {
                $job_obj->forceFill([
                    'status' => 'inprogress',
                ]);
                $job_obj->update();
            }
            return response()->json([
                'status_code' => 200,
                'msg' => 'Job assigned by comapny',
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error in Job accept',
                'error' => $error,
            ]);
        }
    }

    //company job earnings
    public function companyWallet(Request $request)
    {
        $user = $request->user();
        $earnings = CompaniesWallet::with('job')->where('company_id', $user->id)->get();
        if (empty($earnings)) {
            return response()->json([
                'status_code' => 200,
                'msg' => 'No data found.',
            ]);
        }
        return response()->json([
            'status_code' => 200,
            'data' => $earnings
        ]);
    }
    //helper rate
    public function updateHelperRate(Request $request)
    {
        // Check if the request method is POST
        if ($request->isMethod('post')) {
            // Define validation rules
            $validated = $request->validate([
                'helper_rate' => 'required|numeric',
            ]);

            // Retrieve the company record based on the authenticated user's company_id
            $company = Companies::where('user_id', $request->user()->id)->first();

            if ($company) {
                // Update the helper_rate
                $company->helper_rate = $request->input('helper_rate');
                $company->save();

                // Return a success response
                return response()->json([
                    'status' => 200,
                    'message' => 'Helper rate updated successfully.',
                    'data' => $company,
                ], 200);
            } else {
                // Company not found
                return response()->json([
                    'status' => 404,
                    'message' => 'Company not found.',
                ], 404);
            }
        } else {
            // Wrong request method
            return response()->json([
                'status' => 405,
                'message' => 'You are trying with wrong method.',
            ], 405);
        }
    }
}
