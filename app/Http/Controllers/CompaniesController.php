<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\Companies;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Session;
use Hash;
use DataTables;
use Mail;
use PDF;
use DB;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['usercompanies'] = User::where('user_type','=',2)->with('checkout')->get();

        return view('companies.companies' , $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id = null)
    {
        $user = $request->user();

        if ($user) {
            $Companies = new Companies();
            $title = "Add";
            $message = "Addedd Successfully";

            if (session::get('userAccessArr')['CompaniesAdd'] == 0) {

                $message = "You have not access for this.";
                session::flash('error_message', $message);
                return redirect()->route('dashboard')->with('error_message', 'You have no access for this.');
            }
        } else {

            if (Session::get('userAccessArr')['CompaniesUpdate'] == 0) {
                $message = "You have not access for this.";
                session::flash('error_message', $message);
                return redirect()->route('dashboard')->with('error_message', 'You have no access for this.');
            }

            $Companies = Companies::find($id);
            $message = "Updated Successfully";
        }
        if ($request->isMethod('post')) {

            $data = $request->all();

            $rules = array(
                'title' => 'required',
                'web' => 'required',
                'description' => 'required',
            );
            $this->validate($request, $rules);
            DB::beginTransaction();

            $Companies->user_id = trim(Auth::user()->id);
            $Companies->title = trim($data['title']);
            $Companies->web = trim($data['web']);
            $Companies->description = trim($data['description']);

            if ($id == "") {
                $Companies->created_by = Auth::user()->id;
            } else {

                $Companies->updated_by = Auth::user()->id;
            }
            $Companies->save();
            DB::commit();
            Session::flash("success_message", $message);
            return redirect()->route('CompaniesView');
        }
        return view('companies.CompaniesAdd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Companies  $companies
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['user'] = User::with('checkout')->find($id);
        return view('companies.companyview' ,$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Companies  $companies
     * @return \Illuminate\Http\Response
     */
    public function edit(Companies $companies)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Companies  $companies
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Companies $companies)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Companies  $companies
     * @return \Illuminate\Http\Response
     */
    public function destroy(Companies $companies)
    {
        //
    }

    public function changeofferStatus($id)
    {
        $user = User::find($id);
        if ($user->status == '1') {
            $user->status = '0';
            $user->save();
            return redirect()->back()->with('success', 'User  Inactive successfully!');
        } elseif ($user->status == '0') {
            $user->status = '1';
            $user->save();
            return redirect()->back()->with('success', 'User  Active successfully!');
        }
    }
    public function addUpdateTotalDaysofPayment(Request $request , $id){
        $user = User::find($id);
        $user->payment_days = $request->user_total_day_to_paid;
        $user->save();
        return redirect()->back()->with('success', 'User payment days added successfully!');
    }

}
