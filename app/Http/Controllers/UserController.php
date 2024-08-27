<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


use App\Models\User;
use App\Models\UserRoles;
use App\Models\UserAccessManages;

use Session;
use Hash;
use DataTables;
use Mail;
use PDF;

class UserController extends Controller
{

    /*checkCurrentPassword*/
    public function checkCurrentPassword(Request $request, $id = null)
    {
        $data = $request->all();

            if (Hash::check($data['current_password'], Auth::user()->password)) {
                return "true";

            } else {
                return "false";

            }

    }

    /*settings*/
    public function settings(Request $request, $id = null)
    {
        if ($request->isMethod('post')) {

            $data = $request->all();
//            echo "<PRE>";print_r($data);exit;

            $rules = array(
                'name' => 'required|max:255',
                'mobile' => 'required|min:11',
                'password' => 'required|min:6',
                'password_confirm' => 'required|min:6',
            );


            $this->validate($request, $rules);

            if ($data['password'] == $data['password_confirm']) {

                $User = User::find(Auth::user()->id);
                $User->name = $data['name'];
                $User->mobile = $data['mobile'];
                $User->password = bcrypt($data['password']);
                $User->updated_by = Auth::user()->id;
                $User->save();

                $message = "Updated Successfully";
                Session::flash("success_message", $message);
                return redirect()->back();

            }
        }


        return view('users.settings');
    }

    /*usersCreate*/
    public function usersCreate(Request $request, $id = null)
    {
        if ($id == "") {

            if (Session::get('userAccessArr')['user-add'] == 0) {

                $message = "You have not access for this.";
                session::flash('error_message', $message);

                return redirect()->route('dashboard');

            }

            $User = new User();
            $message = "Addedd Successfully...";
            $title = "Create";

        } else {

            if (Session::get('userAccessArr')['user-edit'] == 0) {

                $message = "You have not access for this.";
                session::flash('error_message', $message);

                return redirect()->route('dashboard');

            }

            $User = User::find($id);
            $message = "Updated Successfully...";
            $title = "Update";

        }


        if ($request->isMethod('post')) {

            $data = $request->all();
//            echo "<PRE>";print_r($data);exit;

            $rules = array(
                'name' => 'required|max:255',
                'user_type' => 'required|max:255',
                'mobile' => 'required|min:11',
                'password' => 'required|min:6',
                'password_confirm' => 'required|min:6',
                'email' => 'required|email|max:255',
            );


            $this->validate($request, $rules);
            if ($id == "") {


                $userCheck = User::where('email', $data['email'])->count();
                if ($userCheck > 0) {
                    $message = "Email Already exist";
                    session::flash('error_message', $message);
                    return redirect()->back();
                } else {

                    if ($data['password'] == $data['password_confirm']) {

                        $User->name = $data['name'];
                        $User->email = $data['email'];
                        $User->user_type = $data['user_type'];
                        $User->mobile = $data['mobile'];
                        $User->password = bcrypt($data['password']);
                        $User->image = "default-admin.jpeg";

                        if ($id == "") {
                            $User->created_by = Auth::user()->id;
                        } else {

                            $User->updated_by = Auth::user()->id;
                        }
                        $User->save();

                        /*Send email to active account*/
                        $email = $data['email'];
                        $messageData = array(
                            'code' => base64_encode($data['email']),
                            'email' => $data['email'],
                            'name' => $data['name'],
                            'password' => $data['password'],
                            'mobile' => $data['mobile']

                        );

//                        return view('emails.confirmAccount')->with(compact('messageData'));


                        $sent =  Mail::send('emails.confirmAccount', $messageData, function ($message) use ($email) {

                            $message->to($email)->subject('Confirm Account');
                            $message->bcc("safanali@yopmail.com", "sufee latif");

                        });



//                        echo "sent ".$sent;
//                        exit;


                        Session::flash("success_message", $message);
                        return redirect()->route('users');

                    } else {

                        Session::flash('error_message', 'New Password and Confirm Password Not Matched');
                        return redirect()->back();

                    }
                }
            } else {
                if ($data['password'] == $data['password_confirm']) {

                    $User->name = $data['name'];
                    $User->user_type = $data['user_type'];
                    $User->mobile = $data['mobile'];
                    $User->password = bcrypt($data['password']);
                    $User->image = "default-admin.jpeg";

                    if ($id == "") {
                        $User->created_by = Auth::user()->id;
                    } else {

                        $User->updated_by = Auth::user()->id;
                    }
                    $User->save();

                    $message = "Updated Successfully";
                    Session::flash("success_message", $message);
                    return redirect()->route('users');
                } else {

                    Session::flash('error_message', 'New Password and Confirm Password Not Matched');
                    return redirect()->back();

                }
            }

        }


        $UserRoles = UserRoles::orderby('id', 'desc')->where('id', '>', 1)->get()->toArray();
//        echo "<PRE>";print_r($UserRoles);exit;
        return view('users.createUpdate')->with(compact('UserRoles', 'User', 'title'));

    }


    /*confirmAccount*/
    public function confirmAccount($email)
    {
        $email = base64_decode($email);


        $userCount = User::where(
            'email', $email
        )->count();

        if ($userCount > 0) {
            $userDetails = User::where('email', $email)->first();
            if ($userDetails->status == 1) {


                $message = "Your Email account is already activated. You can login now";
                session::flash('success_message', $message);
                return redirect()->route('sign_in');

//                return redirect('login-register')->with('success_message', 'You Email account is already activated. You can login now');
            } else {


                User::where('email', $email)->update(['status' => 1]);


                /*Send welcome email to active account*/
                $email = $email;
                $messageData = array(
                    'email' => $email,
                    'name' => $userDetails->name,
                    'mobile' => $userDetails->mobile,

                );


                Mail::send('emails.WelcomeAccount', $messageData, function ($message) use ($email) {

                    $message->to($email)->subject('Welcome');
                    $message->bcc("safanali@yopmail.com", "sufee latif");

                });

                $message = "Your Email account  activated. You can login now";
                session::flash('success_message', $message);
                return redirect()->route('sign_in');

//                return redirect('login-register')->with('success_message', 'You Email account  activated. You can login now');

            }
        } else {

            abort(404);
//            return view('404');


        }

    }

    /*check Email*/
    public function userCheckEmail(Request $request)
    {

        $data = $request->all();
        $emailCount = User::where('email', $data['email'])->count();
        if ($emailCount > 0) {
            return "false";
        } else {
            return "true";
        }

    }

    /*userRoles*/
    public function userRoles(Request $request, $id = null)
    {

        if (Session::get('userAccessArr')['user-role-view'] == 0) {

            $message = "You have not access for this.";
            session::flash('error_message', $message);

            return redirect()->route('dashboard');

        }


        if ($request->isMethod('post')) {

            if ($id == "") {

                if (Session::get('userAccessArr')['user-role-add'] == 0) {

                    $message = "You have not access for this.";
                    session::flash('error_message', $message);

                    return redirect()->route('dashboard');

                }

                $UserRoles = new UserRoles();
                $message = "Addedd Successfully";

            } else {

                if (Session::get('userAccessArr')['user-role-edit'] == 0) {

                    $message = "You have not access for this.";
                    session::flash('error_message', $message);

                    return redirect()->route('dashboard');

                }

                $UserRoles = UserRoles::find($id);
                $message = "Updated Successfully";

            }


            $data = $request->all();
//            echo "<PRE>";print_r($data);exit;

            $rules = array(
                'title' => 'required|max:255',
            );


            $this->validate($request, $rules);

            $UserRoles->title = $data['title'];
            if ($id == "") {


                $UserRoles->created_by = Auth()->user()->id;


            } else {


                $UserRoles->updated_by = Auth()->user()->id;
                $UserRoles->updated_at = date('Y-m-d H:m:s');


            }

            $UserRoles->save();


            session::flash('success_message', $message);
            return redirect()->route('userRoles');
        }


        $UserRoles = UserRoles::orderby('id', 'desc')->where('id', '>', 1)->get()->toArray();
//        echo "<PRE>";print_r($UserRoles);exit;

        return view('users.userRoles')->with(compact('UserRoles'));
    }

    /*deleteUserRoles*/
    public function deleteUserRoles($id)
    {

        if (Session::get('userAccessArr')['user-role-delete'] == 0) {

            $message = "You have not access for this.";
            session::flash('error_message', $message);

            return redirect()->route('dashboard');

        }

        UserRoles::where('id', $id)->delete();

        $message = "Deleted successfully";

        Session::flash("success_message", $message);
        return redirect()->back();

    }


    /*deleteUser*/
    public function deleteUser($id)
    {

        if (Session::get('userAccessArr')['user-delete'] == 0) {

            $message = "You have not access for this.";
            session::flash('error_message', $message);

            return redirect()->route('dashboard');

        }

        User::where('id', $id)->delete();

        $message = "Deleted successfully";

        Session::flash("success_message", $message);
        return redirect()->back();

    }

    /*userRoleAccess*/
    public function userRoleAccess(Request $request, $id = null)
    {

        if ($request->isMethod('post')) {

            $data = $request->all();

//            echo "<PRE>";
//            print_r($data);
//            exit;

            if (!empty($data['access'])) {
                UserAccessManages::where("user_role_id", $data['userID'])->delete();

                foreach ($data['access'] as $access) {

                    $UserAccessManages = new UserAccessManages();
                    $UserAccessManages->user_role_id = $data['userID'];
                    $UserAccessManages->module_id = $access;
                    $UserAccessManages->save();
                }

                $message = "Updated successfully";

                Session::flash("success_message", $message);
                return redirect()->back();
            } else {
                UserAccessManages::where("user_role_id", $data['userID'])->delete();

                $message = "Updated successfully";

                Session::flash("success_message", $message);
                return redirect()->back();

//                $message = "Choose any access please.";
//                session::flash('error_message', $message);
//                return redirect()->back();
            }


        }


        $UserRoles = UserRoles::find($id);
//        $userRoles = UserRoles::where('id',$id)->first();

        return view('users.userRoleAccess')->with(compact('UserRoles'));
    }

    /*users*/
    public function users(Request $request)
    {

        if (Session::get('userAccessArr')['user-view'] == 0) {

            $message = "You have not access for this.";
            session::flash('error_message', $message);

            return redirect()->route('dashboard');

        }

        if ($request->ajax()) {

            $data = User::with('user_roles')->where('user_type', '>', 1);
            $data = $data->get()->toArray();

//            echo "<PRE>";print_r($data);exit;

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('user_role_title', function ($row) {

                    if (!empty($row['user_roles']['title'])) {
                        $user_role_title = $row['user_roles']['title'];
                    } else {
                        $user_role_title = "";
                    }

                    return $user_role_title;
                })
                ->addColumn('action', function ($row) {
                    $btn = "";

                    if (Session::get('userAccessArr')['user-edit'] == 1) {

                        $btn .= ' &nbsp; <a href="' . Route('usersUpdate') . '/' . $row['id'] . '" title="Edit"><i class="icofont icofont-edit"></i></a>';


                    }
                    if (Session::get('userAccessArr')['user-delete'] == 1) {

                        $btn .= ' &nbsp;<a title="Delete" href="javascript:void(0)" class="confirmDelete"  recordid="' . Route('deleteUser') . '/' . $row['id'] . '">
                                        <i class="icofont icofont-ui-delete"></i></a>';

                    }
                    if (Session::get('userAccessArr')['user-edit'] == 0 && Session::get('userAccessArr')['user-delete'] == 0) {

                        $btn .= ' &nbsp;<a href="javascript:void(0);" style="color: black;" onclick="alert(\'You have not access..!\');" class="btn btn-warning btn-xs">No Access</a>';

                    }

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }


        return view('users.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (Auth::check()) {

//            echo "logged in";
//            exit;

            return redirect()->route('dashboard');

        }
//        else
//        {
//            echo "NOt logged in";
//            exit;
//
//        }

        if ($request->isMethod('post')) {


            $data = $request->all();
//            echo "<PRE>";print_r($data);
//            exit;


            $rules = array(
                'email' => 'required|email|max:255',
                'password' => 'required',
            );


            $this->validate($request, $rules);

            if (Auth::attempt(array('email' => $data['email'], 'password' => $data['password'], 'status' => 1))) {

//                if (Auth::check()) {
//                    $user_id = Auth::user()->email;
//                    echo $user_id;
//                    exit;
//                }

                $message = "Successfully logged in...";
                session::flash('success_message', $message);
                return redirect()->route('dashboard');

            } else {

                $message = "Invalid Email or Password";
                session::flash('error_message', $message);
                return redirect()->back();
            }

        }
        return view('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function get_helper($id)
    {

        $response['success'] = 200;
        $response['message'] = 'Details..';
        $response['error'] = [];
        $response['data'] =   User::select('name','image','email','mobile','status as varify')->find($id);;
        $response['data']['address'] ='multan road Lahore';
        $response['data']['rating'] =4.2;
        return response()->json($response);
    }
}
