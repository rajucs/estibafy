<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use App\Models\Languages;


use App\Models\User;
use App\Models\Helpers;

use Session;
use Hash;
use DataTables;
use Mail;
use PDF;
use DB;
use Twilio\Rest\Client;


class APIController extends Controller
{

    /*user forgotPassword*/
    public function forgotPassword(Request $request, $id = null)
    {

        if ($request->isMethod('post')) {


            $data = $request->all();
            //            echo "<PRE>";print_r($data);
            //            exit;

            $rules = array(
                'email' => 'required|email|max:255'
            );


            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(array(
                    'status' => 422,
                    'message' => $validator->errors(),
                ), 422);
            }

            $userCheck = User::where('email', $data['email'])->count();
            if ($userCheck == 0) {
                $message = "Email not exist";

                return response()->json(array(
                    'status' => 422,
                    'message' => $message,
                ), 422);
            }

            $random_password = Str::random(8);
            $new_password = bcrypt($random_password);
            //            User::where('email', $data['email'])->update(['password' => $new_password]);

            $userDetails = User::where('email', $data['email'])->first();
            $userDetails->password = $new_password;
            $userDetails->save();
            $messageData['user_details'] = $userDetails;
            $messageData['random_password'] = $random_password;

            $email = $data['email'];
            $sent = Mail::send('emails.forgotPassword', $messageData, function ($message) use ($email) {

                $message->to($email)->subject('Forgot Password');
                $message->bcc("arman.cs.bd@gmail.com", "Forgot Password");
            });

            $message = "Check your email plz we sent new password to you.";

            return response()->json(array(
                'status' => 200,
                'message' => $message,
            ), 200);
        }
    }
    /*helper forgotPassword*/
    public function helperForgotPassword(Request $request, $id = null)
    {

        if ($request->isMethod('post')) {


            $data = $request->all();
            //            echo "<PRE>";print_r($data);
            //            exit;

            $rules = array(
                'email' => 'required|email|max:255'
            );


            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(array(
                    'status' => 422,
                    'message' => $validator->errors(),
                ), 422);
            }

            $userCheck = Helpers::where('email', $data['email'])->count();
            if ($userCheck == 0) {
                $message = "Email not exist";

                return response()->json(array(
                    'status' => 422,
                    'message' => $message,
                ), 422);
            }

            $random_password = Str::random(8);
            $new_password = bcrypt($random_password);
            //            User::where('email', $data['email'])->update(['password' => $new_password]);

            $userDetails = Helpers::where('email', $data['email'])->first();
            $userDetails->password = $new_password;
            $userDetails->save();
            $messageData['user_details'] = $userDetails;
            $messageData['random_password'] = $random_password;

            $email = $data['email'];
            $sent = Mail::send('emails.forgotPassword', $messageData, function ($message) use ($email) {

                $message->to($email)->subject('Forgot Password');
                $message->bcc("arman.cs.bd@gmail.com", "Forgot Password");
            });

            $message = "Check your email plz we sent new password to you.";

            return response()->json(array(
                'status' => 200,
                'message' => $message,
            ), 200);
        }
    }

    /*usersUpdate*/
    public function usersUpdate(Request $request, $id = null)
    {
        if ($request->isMethod('post')) {

            $data = $request->all();
            //            echo "<PRE>";print_r($data);
            //            exit;

            $rules = array(
                'name' => 'required|max:255',
                'mobile' => 'required|min:11',
                'password' => 'required|min:6',
                'password_confirm' => 'required|min:6',
            );


            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(array(
                    'status' => 422,
                    'message' => $validator->errors(),
                ));
            }

            if ($data['password'] != $data['password_confirm']) {

                $message = "Password not matched";
                return response()->json(array(
                    'status' => 422,
                    'errors' => null,
                    'message' => $message,
                ), 422);
            }


            $User = User::find(Auth::user()->id);
            $User->name = $data['name'];
            $User->mobile = $data['mobile'];
            $User->password = bcrypt($data['password']);
            $User->updated_by = Auth::user()->id;

            // Upload Image
            if ($request->hasFile('main_image')) {
                $image_tmp = $request->file('main_image');
                if ($image_tmp->isValid()) {

                    $extension = $image_tmp->getClientOriginalExtension();
                    $image_name = $image_tmp->getClientOriginalName();

                    //                    echo $image_name;
                    //                    echo "<BR>";

                    $imageName = rand(111, 99999) . '.' . $extension;
                    //                    $imageName = $image_name.'-'.rand(111, 99999).'.'.$extension;

                    //                    echo $imageName;
                    //                    echo "<BR>";

                    //                    exit;

                    $main_image = public_path('user_images/' . $imageName);
                    $large_cover_image_path = public_path('user_images/large/' . $imageName);
                    $medium_cover_image_path = public_path('user_images/medium/' . $imageName);
                    $small_cover_image_path = public_path('user_images/small/' . $imageName);


                    Image::make($image_tmp)->save($main_image);
                    Image::make($image_tmp)->save($large_cover_image_path);
                    Image::make($image_tmp)->resize(500, 500)->save($medium_cover_image_path);
                    Image::make($image_tmp)->resize(250, 250)->save($small_cover_image_path);

                    $User->image = $imageName;
                }
            }


            $User->save();

            $message = "Updated Successfully";
            return response()->json(array(
                'status' => 200,
                'errors' => null,
                'message' => $message,
            ), 200);
        }
    }

    /*login*/
    public function login(Request $request, $id = null)
    {

        if ($request->isMethod('post')) {


            $data = $request->all();
            //            echo "<PRE>";print_r($data);
            //            exit;

            $rules = array(
                'email' => 'required|email|max:255',
                'password' => 'required',
            );


            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(array(
                    'status' => 422,
                    'message' => $validator->errors(),
                ));
            }

            if (Auth::attempt(array('email' => $data['email'], 'password' => $data['password']))) {

                if (Auth::user()->status == 0) {
                    Auth::logout();
                    $message = "You account not active contact administration.";
                    return response()->json(array(
                        'status' => 422,
                        'message' => $message,
                    ), 422);
                }

                //  if (Auth::user()->isVerified == 0) {
                //     Auth::logout();
                //     $message = "Please Varify Your Phone Number.";
                //     return response()->json(array(
                //         'status' => 422,
                //         'message' => $message,
                //     ), 422);
                // }

                $User = User::where('email', $data['email'])->first();

                //                $accessToken = $User->createToken($data['email'])->accessToken;

                $accessToken = $User->createToken('apptoken')->plainTextToken;

                User::where('email', $data['email'])->update(['access_token' => $accessToken]);

                $u = Auth::user();

                $dataArr['token']["access_token"] = $accessToken;
                $dataArr['token']["token_type"] = 'Bearer';

                // $dataArr['user'] = User::with('company')->find(Auth::user()->id)->toArray() + ['profile_path' => asset('/user_images')];
                $user = User::with('company')->find(Auth::user()->id);
                $dataArr['user'] = $user->toArray() + [
                    'profile_path' => asset('/public/user_images/' . $user->image),
                ];

                $dataArr['helpers'] = Helpers::where('company_id', Auth::user()->id)->with('jobs')->with('earning')->get()->toArray();

                //                echo "<PRE>";print_r($dataArr);exit;

                //                $dataArr['user'] = Auth::user();

                $message = "Successfully logged in...";
                return response()->json(array(
                    'status' => 200,
                    'errors' => null,
                    'message' => $message,
                    'data' => $dataArr
                ), 200);
            } else {

                $message = "Invalid Email or Password";
                return response()->json(array(
                    'status'        => 422,
                    'errprs'        => true,
                    'message'       => $message,
                    'data'          => $data
                ));
            }
        }
    }

    /*userDetails*/
    public function userDetails(Request $request, $id = null)
    {


        if ($id) {
            $id = $id;
        } else {
            $id = $request->user()->id;
        }
        $User = User::find($id);
        return $User;

        return response()->json(array(
            'users' => $User,
            'status' => true
        ));
    }

    /*usersCreate*/
    public function usersCreate(Request $request, $id = null)
    {
        //        echo "HERE";exit;
        // dd($request->all());
        if ($request->isMethod('post')) {

            $data = $request->all();
            $rules = array(
                'name' => 'required|max:255',
                'user_type' => 'required|max:255',
                'mobile' => 'required|min:11|unique:users,mobile',
                'password' => 'required|min:6',
                'password_confirm' => 'required|min:6',
                'email' => 'required|email|max:255',
            );

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                // Flatten the errors array
                $flattenedErrors = [];
                foreach ($errors as $fieldErrors) {
                    foreach ($fieldErrors as $message) {
                        $flattenedErrors[] = $message;
                    }
                }

                return response()->json([
                    'status' => 422,
                    'message' => count($flattenedErrors) === 1 ? $flattenedErrors[0] : $flattenedErrors,
                ], 200);
            }



            $userCheck = User::where('email', $data['email'])->count();
            if ($userCheck > 0) {
                $message = "Email Already exist";

                return response()->json(
                    array(
                        'status' => 422,
                        'message' => $message
                    ),
                    200
                );
            }

            $latitude = $request->latitude;
            $longitude = $request->longitude;


            if ($data['password'] == $data['password_confirm']) {

                //twillio otp verification
                // $token = getenv("TWILIO_AUTH_TOKEN");
                // $twilio_sid = getenv("TWILIO_ACCOUNT_SID");
                // $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
                // // return [$twilio_sid,$twilio_verify_sid,$token];

                // // dd($twilio_verify_sid);

                // $twilio = new Client($twilio_sid, $token);
                // $twilio->verify->v2->services($twilio_verify_sid)
                // ->verifications
                // ->create($data['mobile'], "sms");
                // return "asf";
                // dd($twilio);

                $User = new User();
                $User->name = $data['name'];
                $User->email = $data['email'];
                $User->user_type = $data['user_type'];
                $User->mobile = $data['mobile'];
                $User->password = bcrypt($data['password']);
                $User->image = "default-admin.png";
                $User->latitude = $latitude;
                $User->longitude = $longitude;
                $User->status = 1;
                $User->isVerified = true;
                // Upload Image
                if ($request->hasFile('company_image')) {
                    $image_tmp = $request->file('company_image');
                    if ($image_tmp->isValid()) {
                        $extension = $image_tmp->getClientOriginalExtension();
                        $imageName = rand(111, 99999) . '.' . $extension;

                        $company_image = public_path('user_images/' . $imageName);
                        $large_cover_image_path = public_path('user_images/large/' . $imageName);
                        $medium_cover_image_path = public_path('user_images/medium/' . $imageName);
                        $small_cover_image_path = public_path('user_images/small/' . $imageName);


                        Image::make($image_tmp)->save($company_image);
                        Image::make($image_tmp)->save($large_cover_image_path);
                        Image::make($image_tmp)->resize(500, 500)->save($medium_cover_image_path);
                        Image::make($image_tmp)->resize(250, 250)->save($small_cover_image_path);

                        $User->image = $imageName;
                    }
                }
                $User->save();

                $UserInfo = DB::getPdo()->lastInsertId();

                //save companies data
                if (isset($data['user_type']) && $data['user_type'] == 2) {
                    $Companies = new Companies();
                    $Companies->user_id = $UserInfo;
                    $Companies->company_name = trim($data['company_name']);
                    $Companies->company_mobile = trim($data['company_mobile']);
                    $Companies->company_address = trim($data['company_address']);
                    $Companies->ruc = trim($data['ruc']);
                    $Companies->save();
                }
                if (Auth::attempt(array('email' => $data['email'], 'password' => $data['password']))) {

                    $accessToken = $User->createToken($data['email'])->plainTextToken;

                    User::where('email', $data['email'])->update(['access_token' => $accessToken]);
                }

                /*Send email to active account*/
                $email = $data['email'];
                $messageData = array(
                    'code' => base64_encode($data['email']),
                    'email' => $data['email'],
                    'name' => $data['name'],
                    'password' => $data['password'],
                    'mobile' => $data['mobile']

                );

                //  return view('emails.confirmAccount')->with(compact('messageData'));
                // $sent = Mail::send('emails.confirmAccount', $messageData, function ($message) use ($email) {

                //     $message->to($email)->subject('Confirm Account');
                //     $message->bcc("safanali@yopmail.com", "sufee latif");
                // });

                $dataArr['token']["access_token"] = $accessToken;
                $dataArr['token']["token_type"] = 'Bearer';

                // $dataArr['user'] = User::with('company')->find($UserInfo)->toArray();
                $user = User::with('company')->find(Auth::user()->id);
                $dataArr['user'] = $user->toArray() + [
                    'profile_path' => asset('/public/user_images/' . $user->image),
                ];

                $message = "Account created successfully";

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
        //        return "asdfasdf";
        //  return $verification->valid;
        if ($verification->valid) {
            $user = tap(User::where('mobile', $data['mobile']))->update(['isVerified' => true]);
            return response()->json(array(
                'status' => 200,
                'message' => 'Otp Verified',
                'errors' => null,
                'data' => $user,
            ), 200);
        } else {
            return "asdfasdf";
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
    //language switcher
    public function languageSwitcher(Request $request)
    {
        $languages = Languages::where('lang', $request->name)->get();
        $data
            = [];
        foreach ($languages as $language) :
            $data[$language->field_name] = $language->translation;
        endforeach;
        return response()->json(array(
            'data'   => $data,
            'status' => 200,
            'message' => 'Langauge Switched.',
        ), 200);
    }

    //add helper under company
    public function CompanyHelperAdd(Request $request)
    {
        if ($request->isMethod('post')) {
            $company_id = $request->user()->id;
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

                $User = new Helpers();

                $User->name = $data['name'];
                $User->email = $data['email'];
                $User->mobile = $data['mobile'];
                $User->password = bcrypt($data['password']);


                $User->latitude = $data['latitude'];


                $User->longitude = $data['longitude'];

                $User->apartment = $data['apartment'] ?? '';
                $User->city = $data['city'];
                $User->province = $data['province'];
                $User->country = $data['country'];
                $User->company_id = $company_id;
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

                $dataArr['token']["access_token"] = $accessToken;
                $dataArr['token']["token_type"] = 'Bearer';

                $dataArr['helper'] = Helpers::where('id', $UserInfo)->get();

                $message = "Helper Succesfully added.";

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
        } else {
            $message = "You are trying with wrong method.";
            return response()->json(array(
                'status' => 404,
                'message' => $message,
            ), 404);
        }
    }
    //get all hlpers by comapny
    public function CompanyHelpers(Request $request)
    {

        $company_id = $request->user()->id;
        $helpers = Helpers::where('company_id', $company_id)->get();

        return response()->json(array(
            'status' => 200,
            'errors' => null,
            'data' => $helpers,
        ), 200);
    }
    //get all hlpers by comapny
    public function CompanyHelperDelete(Request $request, $id)
    {

        $company_id = $request->user()->id;
        Helpers::where('company_id', $company_id)->where('id', $id)->delete();

        $message = "Helper deleted successfully.";
        return response()->json(array(
            'status' => 200,
            'message' => $message,
        ), 404);
    }
}
