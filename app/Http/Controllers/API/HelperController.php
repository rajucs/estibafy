<?php

namespace App\Http\Controllers\API;

use App\Events\FCMNotificationEvent;
use App\Helper as AppHelper;
use App\Http\Controllers\Controller;
use App\Models\AdminEarningPercentage;
use App\Models\BaseFire;
use App\Models\Helpers;
use App\Models\Job;
use App\Models\JobAssets;
use App\Models\JobHelpers;
use App\Models\JobHelperGeoData;
use App\Models\Checkout;
use App\Models\Companies;
use App\Models\HelperWallet;
use App\Models\Jobs;
use App\Models\Tax;
use App\Models\User;
use App\Models\CompaniesWallet;
use Carbon\Carbon;
use Exception;
use Faker\Extension\Helper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Twilio\Rest\Client;

class HelperController extends Controller
{
    /*usersCreate*/
    public function usersCreate(Request $request)
    {
        // dd($request->all());

        if ($request->isMethod('post')) {

            $data = $request->all();

            $rules = array(
                'name' => 'required|max:255',
                'mobile' => 'required|unique:helpers,mobile',
                'password' => 'required|min:6',
                'password_confirm' => 'required|min:6',
                'email' => 'required|email|max:255',


                // 'apartment' => 'required',
                'city' => 'required',
                'province' => 'required',
                'country' => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(array(
                    'status' => 422,
                    'message' => $validator->errors(),
                ), 422);
            }

            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $message = "Please Enter Validate Email";

                return response()->json(array(
                    'status' => 422,
                    'message' => $message,
                ), 422);
            }
            $userCheck = Helpers::where('email', $data['email'])->count();
            // dd($userCheck);
            if ($userCheck > 0) {
                $message = "Email Already exist";

                return response()->json(
                    array(
                        'status' => 422,
                        'message' => $message
                    ),
                    422
                );
            }
            if ($data['password'] == $data['password_confirm']) {

                // $token = getenv("TWILIO_AUTH_TOKEN");
                // $twilio_sid = getenv("TWILIO_ACCOUNT_SID");
                // $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
                // $twilio = new Client($twilio_sid, $token);
                // $twilio->verify->v2->services($twilio_verify_sid)
                //     ->verifications
                //     ->create($data['mobile'], "sms");

                $User = new Helpers();
                if ($request->file('image')) {
                    $file = $request->file('image');
                    $image = time() . '_' . $file->getClientOriginalName();
                    $file->move('helpers',  $image);
                    $User->image = $image;
                }
                $User->name = $data['name'];
                $User->email = $data['email'];
                $User->mobile = $data['mobile'];
                $User->password = bcrypt($data['password']);
                $User->street_address = $data['street_address'];
                $User->latitude = $data['latitude'];
                $User->longitude = $data['longitude'];
                $User->apartment = $data['apartment'] ?? '';
                $User->city = $data['city'];
                $User->province = $data['province'];
                $User->country = $data['country'];
                $User->isVerified = true;
                $User->save();
                /*get last inserted order ID*/

                $UserInfo = DB::getPdo()->lastInsertId();

                if (
                    Auth::guard('helper')->attempt(array('email' => $data['email'], 'password' => $data['password']))
                ) {
                    $accessToken = $User->createToken($data['email'])->plainTextToken;
                    Helpers::where('email', $data['email'])->update(['access_token' => $accessToken]);
                }

                /*Send email to active account*/
                // $email = $data['email'];
                // $messageData = array(
                //     'code' => base64_encode($data['email']),
                //     'email' => $data['email'],
                //     'name' => $data['name'],
                //     'password' => $data['password'],
                //     'mobile' => $data['mobile']
                // );

                // $sent = Mail::send('emails.confirmAccount', $messageData, function ($message) use ($email) {

                //     $message->to($email)->subject('Confirm Account');
                //     $message->bcc("safanali@yopmail.com", "sufee latif");
                // });

                $dataArr['token']["access_token"] = $accessToken;
                $dataArr['token']["token_type"] = 'Bearer';

                $dataArr['helper'] = Helpers::where('id', $UserInfo)->get();

                $message = "Account created successfully please confirm it from your email";

                return response()->json(array(
                    'status' => 200,
                    'message' => $message,
                    'errors' => null,
                    'data' => $dataArr,
                ), 200);
            } else {
                $message = "Password and Confirm Password Not Matched";
                return response()->json(array(
                    'status' => 422,
                    'message' => $message,
                ), 422);
            }
        }
    }

    public function verifyOtp(Request $request, $id = null)
    {
        $data = $request->validate([
            'verification_code' => ['required', 'numeric'],
            'mobile' => ['required', 'string'],
        ]);
        /* Get credentials from .env */
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_ACCOUNT_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new Client($twilio_sid, $token);
        $verification = $twilio->verify->v2->services($twilio_verify_sid)
            ->verificationChecks
            ->create($data['verification_code'], array('to' => $data['mobile']));

        if ($verification->valid) {
            $user = tap(Helpers::where('mobile', $data['mobile']))->update(['isVerified' => true]);
            return response()->json(array(
                'status' => 200,
                'message' => 'Otp Verified',
                'errors' => null,
                'data' => $user,
            ), 200);
        }

        $message = "Otp Not Verified";
        return response()->json(array(
            'status' => 422,
            'message' => $message,
        ), 422);
    }
    public function resendOtp(Request $request)
    {
        $data = $request->validate([
            'mobile' => ['required', 'string'],
        ]);
        //twillio otp verification
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_ACCOUNT_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");

        $twilio = new Client($twilio_sid, $token);
        $twilio->verify->v2->services($twilio_verify_sid)
            ->verifications
            ->create($data['mobile'], "sms");
        return response()->json(array(
            'status' => 200,
            'message' => 'Otp Resent',
        ), 200);
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->messages(), 200);
            }
            $credentials = request(['email', 'password']);
            // return $credentials;

            if (!Auth::guard('helper')->attempt($credentials)) {

                return response()->json([
                    'status_code'   => 422,
                    'error'     => true,
                    'message'   => 'Unauthorized',
                    'data'      => $credentials
                ]);
            }
            $helper_admin_approval_status =  Auth::guard('helper')->user()->approved;
            if ($helper_admin_approval_status == 'No') {
                return response()->json([
                    'status_code' => 201,
                    'msg' => 'Inactive by Admin or pending for admin approval',
                ]);
            }

            // if (Auth::guard('helper')->user()->isVerified == 0) {
            //     //                Auth::logout();
            //     $message = "Please Varify Your Phone Number.";
            //     return response()->json(array(
            //         'status' => 422,
            //         'message' => $message,
            //     ), 422);
            // }
            // if (Auth::guard('helper')->user()->status == '0' || Auth::guard('helper')->user()->approved == 'No') {
            //     return response()->json([
            //         'status_code' => 201,
            //         'msg' => 'Inactive by Admin or pending for approval',
            //     ]);
            // }

            // if (Auth::guard('helper')->attempt(['email' => request('email'), 'password' => request('password'), 'status' => '1', 'approved' => 'Yes'])) {

            if (Auth::guard('helper')->attempt(['email' => request('email'), 'password' => request('password'), 'approved' => 'Yes'])) {
                $base_fare      = BaseFire::first();
                $tax = Tax::first();
                $service_charge = AdminEarningPercentage::first();
                $base_fare_val  = $base_fare->base_fare ?? 0;
                $tax_val        = $tax->tax_percentage ?? 0;
                $service_charge_val = $service_charge->earning_percentage ?? 0;
                $job_settings   = [
                    'base_fare' => $base_fare_val,
                    'tax'       => $tax_val,
                    'service_charge' => $service_charge_val
                ];
                $user = Auth::guard('helper')->user();
                // dd($job_settings);
                $Token =  $user->createToken('authToken')->plainTextToken;

                $helper_earning = HelperWallet::where('helper_id', Auth::guard('helper')->user()->id)->get();
                // dd($helper_earning);
                foreach ($helper_earning as $earning_obj) {
                    $created_at = $earning_obj->created_at;
                    if ($earning_obj->release_status == 'pending') {
                        if (strtotime($created_at) < time() + 86400) {
                            $helper_wallet = HelperWallet::find($earning_obj->id);
                            $helper_wallet->release_status = 'released';
                            $helper_wallet->update();
                        }
                    }
                }

                return response()->json([
                    'error' => false,
                    'user' => $user,
                    'job_settings' => $job_settings,
                    'access_token' => $Token,
                ]);
            } else {
                return response()->json([
                    'error' => true,
                    'msg' => 'helper is inavtivated  by admin '
                ]);
            }
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error in Login',
                'error' => $error,
            ]);
        }
    }


    public function profile(Request $request)
    {
        //validator place
        $users = $request->user();


        if ($request->name == '') {
            $users->name = $users->name;
        } else {
            $users->name = $request->name;
        }
        if ($request->mobile == '') {
            $users->mobile = $users->mobile;
        } else {
            $users->mobile = $request->mobile;
        }



        if ($request->apartment == '') {
            $users->apartment = $users->apartment;
        } else {
            $users->apartment = $request->apartment;
        }

        if ($request->city == '') {
            $users->city = $users->city;
        } else {
            $users->city = $request->city;
        }


        if ($request->province == '') {
            $users->province = $users->province;
        } else {
            $users->province = $request->province;
        }

        if ($request->country == '') {
            $users->country = $users->country;
        } else {
            $users->country = $request->country;
        }


        // "apartment": "3",
        // "city": "asdf",
        // "province": "asfasdf",
        // "country": "asdfasdf",


        // if ($request->email == '') {
        //     $users->email = $users->email;
        // } else {
        //     $users->email = $request->email;
        // }

        if ($request->latitude == '') {
            $users->latitude = $users->latitude;
        } else {
            $users->latitude = $request->latitude;
        }

        if ($request->longitude == '') {
            $users->longitude = $users->longitude;
        } else {
            $users->longitude = $request->longitude;
        }

        if ($request->image == '') {
            $users->image = $users->image;
        } else {
            if ($request->file('image')) {
                $file = $request->file('image');
                $image = time() . '_' . $file->getClientOriginalName();
                $file->move('helpers',  $image);
                $users->image = $image;
            }
        }

        $users->save();
        $userData = Helpers::where('id', $users->id)->first();
        return response()->json(['statusCode' => 200, 'msg' => 'success', 'data' => $userData]);
    }

    public function jobscount(Request $request)
    {
        $jobs = $request->user();
        // dd($jobs);
        // return $jobs;
        if ($jobs) {
            $user['ActiveJobs'] = Jobs::where('status', '1')->get()->count();
            // dd($user);
            $user['Inprocess'] = JobHelpers::with('job', 'job.checkout', 'job.user', 'job.user.company')->where('helper_id', $jobs->id)->where('status', 'inprocess')->get();
            // dd($user);
            $user['Completed'] = JobHelpers::with('job', 'job.checkout', 'job.user', 'job.user.company')->where('helper_id', $jobs->id)->where('status', 'completed')->get()->count();
            $user['Cancelled'] = JobHelpers::with('job', 'job.checkout', 'job.user', 'job.user.company')->where('helper_id', $jobs->id)->where('status', 'cancelled')->get()->count();
            // $user['active_jobs'] =  Checkout::with('job','job.container')->where(['status'=>'pending'])->get();

            $user['accepted_job'] = JobHelpers::with('job', 'job.checkout', 'job.user', 'job.user.company')->where('helper_id', $jobs->id)->where('status', 'accepted')->get();

            $query = "SELECT job_id,helper_id FROM job_helpsers";

            $a = \DB::select($query);
            $temp = [];
            $active_job_list = [];
            $helper_accepted_job_list = [];
            $jobs_helper = [];
            foreach ($a as $b) {
                // return $b;
                array_push($temp, $b->job_id);
            }
            // dd($a);

            $y =  Checkout::with('job', 'job.job_helpers', 'job.container', 'job.user', 'job.user.company')->where(['status' => 'approved'])->get();
            // dd($y);
            foreach ($y as $r) {
                // dd(count($r['job']['job_helpers']));
                $total_helper = $r->total_helpers;
                $helper_occupied = $r['job']['job_helpers'];
                // dd($helper_occupied);
                $helpers = [];
                if (count($helper_occupied) > 0) {
                    foreach ($helper_occupied as $helper) {
                        array_push($helpers, $helper->helper_id);
                    }
                }
                if ($total_helper > count($helper_occupied) && !in_array($jobs->id, $helpers)) {
                    array_push($active_job_list, $r);
                }
                $helper_accepted_job_list[] = JobHelpers::where('job_id', $r->job_id)->where('status', 'accepted')->get();
            }
            // $active_job_details = JobHelpers::with('jobAsset', 'job', 'job.checkout', 'job.user', 'job.user.company')->where('helper_id', $jobs->id)->where('status', 'inprocess')->get();
            $user['accepted_helpers'] = $helper_accepted_job_list;
            $user['active_jobs'] = $active_job_list;
        }

        $helpers_id = JobHelpers::select('job_id')->where('helper_id', $request->user()->id)->get()->toArray();
        $array = $helpers_id;
        if ($helpers_id) {
            $user['getjobs'] = Job::with('checkout', 'user', 'user.company')->whereNotIn('id', $array)
                ->get();
        } else {
            $user['getjobs'] = Job::with('checkout', 'user', 'user.company')->where('status', '1')->get();
        }
        return response()->json([
            'status_code' => 200,
            'data' => $user,
        ]);
    }

    public function jobdetial(Request $request)
    {
        $user = $request->user();
        $data = Helpers::with('Completed.user.company', 'Completed.job.checkout', 'Inprocess.user.company', 'Inprocess.job.checkout', 'Inprogress.user.company', 'Inprogress.job.checkout', 'Declined.user.company', 'Accepted.job.checkout', 'Accepted.user.company', 'Declined.job.checkout')->where('id', $user->id)->first();

        //
        //  $data = Checkout::with('job')->get();


        //

        return response()->json([
            'status_code' => 200,
            'helper' => $data,
        ]);
    }

    public function jobactions(Request $request)
    {
        try {
            $job = $request->user();
            // dd($request->job_id);

            $data = JobHelpers::where(['helper_id' => $job->id, 'job_id' => $request->job_id])->first();
            // edit by Ahsan
            if (!$data) {

                $job_obj = Job::find($request->job_id);
                if (!$job_obj) {
                    return response()->json([
                        'status_code' => 404,
                        'msg' => 'Job not found',
                    ]);
                }
                $user_id = $job_obj->user_id;
                $helper_id =  $request->user()->id;
                $job_id =  $request->job_id;
                $status = $request->status;
                $job_comment_status = 'accepted';



                $jh = new JobHelpers();
                $jh->job_id = $job_id;
                $jh->user_id = $user_id;
                $jh->helper_id = $helper_id;
                $jh->status = $status;
                $jh->job_comment_status = $job_comment_status;
                $jh->approved_by = 'system';
                $jh->save();

                $job_entry = Job::find($job_id);
                $reciever = User::find($job_entry->user_id);
                event(new FCMNotificationEvent("The Job '" . $job_entry->name . "'" . " was accepted just now! Tap for more details", "Job Accepted", "https://grid.gograph.com/driver-in-front-of-school-bus-vector-art_gg57726891.jpg", [$reciever]));

                return response()->json([
                    'status_code' => 200,
                    'msg' => 'Job accepted by system',
                ]);
            } else {
                return response()->json([
                    'status_code' => 210,
                    'msg' => 'Already applied for this job',
                ]);
            }
            //edit by arman
            $all_helper_jobs = JobHelpers::where([
                ['job_id', '=', $request->job_id],
                ['status', '=', 'inprocess']
            ])->get();
            // dd($all_helper_jobs);

            $job_data = Checkout::where('job_id', '=', $request->job_id)->first();
            $total_helper_job = count($all_helper_jobs);
            $total_job_helper = $job_data->total_helpers;
            if ($total_helper_job == $total_job_helper) {
                $job_data->forceFill([
                    'status' => 'inprogress',
                ]);
                $job_data->update();
            }

            if ($data->job_comment_status == 'bid') {
                return response()->json([
                    'status_code' => 201,
                    'msg' => 'Waiting for user to approve request, to proceed further',
                ]);
            }

            // end edit by ahsan

            if ($request->status == 'accepted') {
                $data->forceFill([
                    'status' => $request->status,
                    'job_comment_status' => 'bid',
                ]);
                $data->update();
                $job_entry = Job::find($data->job_id);
                $reciever = User::find($job_entry->user_id);

                event(new FCMNotificationEvent("The Job '" . $job_entry->name . "'" . " was accepted just now! Tap for more details", "Job Accepted", "https://grid.gograph.com/driver-in-front-of-school-bus-vector-art_gg57726891.jpg", [$reciever]));


                return response()->json([
                    'status_code' => 200,
                    'msg' => true,
                ]);
            } elseif ($request->status == 'declined') {
                $data->forceFill([
                    'status' => $request->status,
                    'job_comment_status' => 'bid',
                ]);
                $data->update();

                return response()->json([
                    'status_code' => 200,
                    'msg' => true,
                ]);
            } elseif ($request->status == 'cancelled') {
                $data->forceFill([
                    'status' => $request->status,
                    'job_comment_status' => 'bid',
                ]);
                $data->update();

                return response()->json([
                    'status_code' => 200,
                    'msg' => true,
                ]);
            } else {
                return response()->json([
                    'status_code' => 403,
                    'msg' => false,
                ]);
            }
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error in Job accept',
                'error' => $error,
            ]);
        }
    }

    public function jobstatus(Request $request)
    {
        $job = $request->user();
        // return $request->input();
        $helper_id_request =  $job->id;

        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $timestemp = $request->timestemp;
        $job_status_request = $request->status;
        $job_id_request = $request->job_id;




        // $query = "SELECT id FROM `job_assets`  WHERE job_id=".$job_id_request . " and job_helper_id=".$helper_id_request;
        // $helpers_id_lsit= \DB::select($query);
        // $job_asset_id = $helpers_id_lsit[0]->id;




        $data = JobHelpers::where(['helper_id' => $job->id, 'job_id' => $request->job_id])->first();
        if (!$data) {
            return response()->json([
                'status_code' => 404,
                'message' => 'You cant start the job unless you accept the job'
            ]);
        }
        $job_helper_tab_id = $data->id;

        if ($request->status == 'started') {
            $data->forceFill([
                'status' => $request->status,
            ]);
            $data->update();
            $job_entry = Job::find($data->job_id);
            $reciever = User::find($job_entry->user_id);
            event(new FCMNotificationEvent("The Job '" . $job_entry->name . "'" . " was started just now! Tap for more details", "Job Started", "https://grid.gograph.com/driver-in-front-of-school-bus-vector-art_gg57726891.jpg", [$reciever]));
        } elseif ($request->status == 'completed') {
            $data->forceFill([
                'status' => $request->status,
            ]);
            $data->update();
            $job_checkout = Checkout::where('job_id', $request->job_id)->first();
            // dd($job_checkout);
            if ($job_checkout && !empty($job_checkout->company_id)) {
                $company_id = $job_checkout->company_id;
                $helper_jobs = JobHelpers::where('job_id', $job_checkout->job_id)->get();
                //by arman
                $total_job_helpers = $job_checkout->total_helpers;
                $total_helper_complete = [];
                foreach ($helper_jobs as $job) {
                    if ($job->status == 'completed') {
                        array_push($total_helper_complete, $job->helper_id);
                    }
                }
                // dd($total_helper_complete);
                if (count($total_helper_complete) == $total_job_helpers) {
                    $job_checkout->forceFill([
                        "status" => "complete",
                    ]);
                    $result = $job_checkout->update();
                    // dd($job_checkout);
                    //by arman
                    if ($result) {
                        $company_commission = Companies::where('user_id', $company_id)->value('helper_rate');

                        $job_total = $job_checkout->total;
                        $tax_fromt_total_amount   = ($job_total * 7) / 100;
                        $total_job_amount         = $job_total - $tax_fromt_total_amount;
                        // $admin_commision          = ($total_job_amount * 20) / 100 + $tax_fromt_total_amount;
                        $admin_commision          = ($total_job_amount * 20) / 100;
                        $company_commission       = (($total_job_amount - $admin_commision) * $company_commission) / 100;
                        $total_job_amount         = $total_job_amount - $admin_commision - $company_commission;
                        $helper_amount            = $total_job_amount / $job_checkout->total_helpers;
                        // dd($company_commission.'-company',$admin_commision.'-admin',$helper_amount.'-helper');

                        CompaniesWallet::create([
                            'company_id'    => $company_id,
                            'checkout_id'   => $job_checkout->id,
                            'job_id'        => $job_checkout->job_id,
                            'total_amount'  => $company_commission,
                            'tax_amount'    => 0,
                            'sub_total'     => $company_commission,
                            'release_status' => 'pending', // Ensure this is a string
                        ]);


                        foreach ($helper_jobs as $job) {
                            $helper_id      = $job->helper_id;
                            $job_id         = $job->job_id;

                            $helperdata =  HelperWallet::create([
                                'checkout_id'       => $job_checkout->id,
                                'helper_id'         => $helper_id,
                                'job_id'            => $job_id,
                                'total_amount'      => $helper_amount,
                                'tax'               => $job_checkout->tax,
                                'sub_total'         => $helper_amount,
                                'tip_id'            => 1,
                                'hours'             => 6,
                                'release_status'    => 'pendding',
                                'payment_credential_id' => 2,
                            ]);
                            // dd('dslfaj ', $helperdata);
                        }
                    }

                    $job_entry = Job::find($job_checkout->job_id);
                    $reciever  = User::find($job_entry->user_id);
                    event(new FCMNotificationEvent("The Job '" . $job_entry->name . "'" . " was completed just now! Tap for more details", "Job Completed", "https://grid.gograph.com/driver-in-front-of-school-bus-vector-art_gg57726891.jpg", [$reciever]));

                    return response()->json([
                        'status_code'   => 200,
                        'msg'           => "Job completed successfully",
                    ]);
                } else {
                    return response()->json([
                        'status_code'   => 200,
                        'msg'           => "You cant complete this job.",
                    ]);
                }
            } else {
                return response()->json([
                    'status_code'   => 200,
                    'msg'           => "Something went wrong. The job is not exist or the company is not assigned.  ",
                ]);
            }
        } elseif ($request->status == 'cancelled') {
            $data->forceFill([
                'status' => 'cancelled',
            ]);
            $data->update();
        }
        //edit by arman
        $all_helper_jobs = JobHelpers::where([
            ['job_id', '=', $request->job_id],
            ['status', '=', 'inprocess']
        ])->get();
        // dd($all_helper_jobs);
        $job_data = Checkout::where('job_id', '=', $request->job_id)->first();
        $total_helper_job = count($all_helper_jobs);
        $total_job_helper = $job_data->total_helpers;
        if ($total_helper_job == $total_job_helper) {
            $job_data->forceFill([
                'status' => 'inprogress',
            ]);
            $job_data->update();
        }
        //edit by arman
        if ($data) {

            // edit by ahsan
            if (!empty($request->file('images'))) {
                if ($request->file('images')) {
                    $file = $request->file('images');
                    $image = time() . '_' . $file->getClientOriginalName();
                    $file->move('public/assets',  $image);
                    //   $document->image = $image;

                    // end edit by ahsan
                    $jobtImage = JobAssets::where(['job_helper_id' => $job_helper_tab_id])->first();

                    if (!$jobtImage) {
                        $jobtImage = JobAssets::forceCreate([
                            "job_helper_id" => $job_helper_tab_id,
                        ]);
                    }


                    if ($job_status_request == 'started') {
                        $jobtImage->start_image =   $image;
                        $jobtImage->start_job_latitude = $latitude;
                        $jobtImage->start_job_longitude = $longitude;
                        $jobtImage->update();
                    }
                    if ($job_status_request == 'completed') {
                        $jobtImage->end_image =   $image;
                        $jobtImage->stop_job_latitude = $latitude;
                        $jobtImage->stop_job_longitude = $longitude;
                        $jobtImage->update();
                    }
                } else {
                    return response()->json([
                        'status_code' => 201,
                        'msg' => "no image found",
                    ]);
                }
            }
            return response()->json([
                'status_code' => 200,
                'msg' => true,
            ]);
        }
    }

    public static function image($data)
    {
        $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($data['image'], 0, strpos($data['image'], ';')))[1])[1];
        $createSize = Image::make($data['image'])->save(public_path($data['orignal']) . $fileName);
        $createSize->resize(600, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $createSize->save(public_path($data['medium']) . $fileName);
        $createSize->resize(300, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $createSize->save(public_path($data['thumbnail']) . $fileName);
        return $fileName;
    }

    public static function image2($data)
    {

        $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($data['image'], 0, strpos($data['image'], ';')))[1])[1];
        $createSize = Image::make($data['image'])->save(public_path($data['orignal']) . $fileName);
        $createSize->resize(600, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $createSize->save(public_path($data['medium']) . $fileName);
        $createSize->resize(300, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        $createSize->save(public_path($data['thumbnail']) . $fileName);
        return $fileName;
    }

    public function job_completed(Request $request)
    {
        $job_checkout = Checkout::where('job_id', $request->job_id)->first();
        // dd($job_checkout);
        if ($job_checkout && !empty($job_checkout->company_id)) {
            $company_id = $job_checkout->company_id;
            $helper_jobs = JobHelpers::where('job_id', $job_checkout->job_id)->get();
            $company_commission = Companies::where('user_id', $company_id)->value('helper_rate');
            // dd($company_commission);
            //by arman
            $total_job_helpers = $job_checkout->total_helpers;
            $total_helper_complete = [];
            foreach ($helper_jobs as $job) {
                if ($job->status == 'completed') {
                    array_push($total_helper_complete, $job->helper_id);
                }
            }
            // dd($total_helper_complete);
            if (count($total_helper_complete) == $total_job_helpers) {
                $job_total = $job_checkout->total;
                $tax_fromt_total_amount   = ($job_checkout->total * 7) / 100;
                $total_job_amount         = $job_total - $tax_fromt_total_amount;
                // $admin_commision          = ($total_job_amount * 20) / 100 + $tax_fromt_total_amount;
                $admin_commision          = ($total_job_amount * 20) / 100;
                $company_commission       = (($total_job_amount - $admin_commision) * $company_commission) / 100;
                $total_job_amount         = $total_job_amount - $admin_commision - $company_commission;
                $helper_amount            = $total_job_amount / $job_checkout->total_helpers;
                // dd($company_commission.'-company',$admin_commision.'-admin',$helper_amount.'-helper');
                $company_job_data = [
                    'company_id'    => $company_id,
                    'checkout_id'   => $job_checkout->id,
                    'job_id'        => $job_checkout->job_id,
                    'total_amount'  => $company_commission,
                    'tax_amount'    => 0,
                    'sub_total'     => $company_commission,
                    'release_status' => 'pending', // Ensure this is a string
                ];

                $job_checkout->forceFill([
                    "status" => "complete",
                ]);
                $result = $job_checkout->update();
                // dd($job_checkout);
                //by arman
                if ($result) {
                    CompaniesWallet::create($company_job_data);
                    foreach ($helper_jobs as $job) {
                        $helper_id      = $job->helper_id;
                        $job_id         = $job->job_id;

                        $helperdata =  HelperWallet::create([
                            'checkout_id'       => $job_checkout->id,
                            'helper_id'         => $helper_id,
                            'job_id'            => $job_id,
                            'total_amount'      => $helper_amount,
                            'tax'               => $job_checkout->tax,
                            'sub_total'         => $helper_amount,
                            'tip_id'            => 1,
                            'hours'             => 6,
                            'release_status'    => 'pendding',
                            'payment_credential_id' => 2,
                        ]);
                        // dd('dslfaj ', $helperdata);
                    }
                }

                $job_entry = Job::find($job_checkout->job_id);
                $reciever  = User::find($job_entry->user_id);
                event(new FCMNotificationEvent("The Job '" . $job_entry->name . "'" . " was completed just now! Tap for more details", "Job Completed", "https://grid.gograph.com/driver-in-front-of-school-bus-vector-art_gg57726891.jpg", [$reciever]));

                return response()->json([
                    'status_code'   => 200,
                    'msg'           => "Job completed successfully",
                ]);
            } else {
                return response()->json([
                    'status_code'   => 200,
                    'msg'           => "You cant complete this job.",
                ]);
            }
        } else {
            return response()->json([
                'status_code'   => 200,
                'msg'           => "Something went wrong. The job is not exist or the company is not assigned.  ",
            ]);
        }
    }

    public function helper_earning(Request $request)
    {
        // $helper_data  = Helpers::find($request->user()->id);
        // dd($helper_data);
        $helper_earning = HelperWallet::with('job')->where('helper_id', $request->user()->id)->get();

        $temp_job = 0;
        $temp_total_amount = 0;
        $temp_total_days = 0;

        $pending_temp_job = 0;
        $pending_temp_total_amount = 0;
        $pending_temp_total_days = 0;
        // dd($helper_earning);
        foreach ($helper_earning as $earning_obj) {

            if ($earning_obj->release_status == 'done') {
                $temp_job = $temp_job + 1;
                $temp_total_amount = $temp_total_amount + $earning_obj->sub_total;
                $temp_total_days = $temp_total_days + $earning_obj->hours;
                //   return $earning_obj;
                //   return [$temp_job,$temp_total_amount,$temp_total_days];
            } else {

                $pending_temp_job = $pending_temp_job + 1;
                $pending_temp_total_amount = $pending_temp_total_amount + $earning_obj->sub_total;
                $pending_temp_total_days = $pending_temp_total_days + $earning_obj->hours;
            }
        }
        $earning_result_obj = [
            'releases_payment_earning' => [
                'total_jobs_done' => $temp_job,
                'total_amount' => $temp_total_amount,
                'total_number_of_days_worked' => $temp_total_days

            ],
            'unreleased_payment_earning'  => [
                'total_jobs_done' => $pending_temp_job,
                'total_amount' => $pending_temp_total_amount,
                'total_number_of_days_worked' => $pending_temp_total_days
            ],
            'detail_jobs_status' => $helper_earning

        ];
        return response()->json([
            'status_code' => 200,
            'data' => $earning_result_obj,
        ]);
    }

    public function stats(Request $reqeust)
    {
    }

    public function helperprofile()
    {
        $user = auth()->user();
        return response()->json([
            'status_code' => 200,
            'data' => $user,
        ]);
    }

    public function helperInvoice(Request $request)
    {
        $jobs = $request->user();
        // return $jobs;
        if ($jobs) {
            $user['ActiveJobs'] = Jobs::where('status', '1')->get()->count();
            $user['Inprocess'] = JobHelpers::where('helper_id', $jobs->id)->where('status', 'inprocess')->get()->count();
            $user['Completed'] = JobHelpers::where('helper_id', $jobs->id)->where('status', 'completed')->get()->count();
            $user['Cancelled'] = JobHelpers::where('helper_id', $jobs->id)->where('status', 'cancelled')->get()->count();

            // $user['active_jobs'] =  Checkout::with('job','job.container')->where(['status'=>'pending'])->get();

            $query = "SELECT job_id FROM job_helpsers";

            $a = \DB::select($query);
            $temp = [];
            $active_job_list = [];
            foreach ($a as $b) {
                // return $b;
                array_push($temp, $b->job_id);
            }
            $y =  Checkout::with('job', 'job.container')->where(['status' => 'approved'])->get();
            foreach ($y as $r) {
                if (!in_array($r->job_id, $temp)) {
                    array_push($active_job_list, $r);
                }
            }

            $user['active_jobs'] = $active_job_list;
        }

        $helpers_id = JobHelpers::select('job_id')->where('helper_id', $request->user()->id)->get()->toArray();
        $array = $helpers_id;
        // if ($helpers_id) {
        //     $user['getjobs'] = DB::table('jobs')
        //     ->whereNotIn('id', $array)
        //     ->get();
        // }else{
        //     $user['getjobs'] = Jobs::where('status', '1')->get();
        // }
        return response()->json([
            'status_code' => 200,
            'data' => $user,
        ]);
    }

    public function set_helper_job_location(Request $request)
    {
        if (empty($request->job_id) || empty($request->lat) || empty($request->lng)) {
            return response()->json([
                'status_code' => 201,
                'data' => 'Job id ,latitude , longitude can not be empty',
            ]);
        }
        $helper_details = $request->user();
        $helper_job_locatiion = new JobHelperGeoData();
        $helper_job_locatiion->job_id = $request->job_id;
        $helper_job_locatiion->helpers_id = $helper_details->id;
        $helper_job_locatiion->latitude = $request->lat;
        $helper_job_locatiion->longitude = $request->lng;
        $helper_job_locatiion->save();
        return response()->json([
            'status_code' => 200,
            'data' => $helper_job_locatiion,
        ]);
    }

    //developed by arman
    public function account_deletation(Request $request)
    {
        $request->user()->delete();
        $account_delation = 'Your account deleted successfully.';
        return response()->json([
            'status_code' => 200,
            'data' => $account_delation,
        ]);
    }
}






/*

 if ($data) {

            $job_images = $request->images;
            if (isset($job_images)) {

               // $images = str_replace('[', '', str_replace(']', '', $job_images));
                $images   =preg_replace('#^data:image/[^;]+;base64,#', '', $job_images);
                $images = explode(',', $job_images);
                foreach ($images as $key => $item) {

                    $abc = "data:image/png;base64," . $item;
                    $data = [
                        'image' => $abc,
                        'orignal' => '/assets/images/jobimages/orignal/',
                        'medium' => '/assets/images/jobimages/medium/',
                        'thumbnail' => '/assets/images/jobimages/thumbnail/',
                    ];
                    // edit by ahsan
                    if ($request->file('image')) {
                          $file = $request->file('image');
                          $image = time() . '_' . $file->getClientOriginalName();
                          $file->move('helpers',  $image);
                          $document->image = $image;
                    }
                    // end edit by ahsan
                    $jobtImage = JobAssets::where(['job_helper_id' => $job_helper_tab_id])->first();

                    if(!$jobtImage){
                        $jobtImage = JobAssets::forceCreate([
                            "job_helper_id" => $job_helper_tab_id,
                        ]);

                    }


                    if($job_status_request == 'started'){
                        $jobtImage->start_image =  HelperController::image($data);
                        $jobtImage->start_job_latitude = $latitude;
                        $jobtImage->start_job_longitude = $longitude;
                        $jobtImage->update();
                    }
                    if($job_status_request == 'completed'){
                        $jobtImage->end_image =  HelperController::image($data);
                        $jobtImage->stop_job_latitude = $latitude;
                        $jobtImage->stop_job_longitude = $longitude;
                        $jobtImage->update();
                    }



                }
            }

            return response()->json([
                'status_code' => 200,
                'msg' => true,
            ]);
        }

*/
