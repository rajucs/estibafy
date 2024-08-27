<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\Document;
use App\Models\HelperEarningPayments;
use App\Models\Helpers;
use App\Models\JobHelpers;
use App\Models\HelperWallet;
use Illuminate\Http\Request;
use Session;

class HelpersController extends Controller
{
    public function index(Request $request)
    {
        $data['helpers'] = Helpers::with('jobs.job', 'earning')->get();
        // return $data;
        return view('helpers.index', $data);
    }

    public function helper_add()
    {
        $document = Document::select('id', 'id_no')->get();

        // return $document;

        return view('helpers.add')->with('document', $document);
    }

    public function helper_insert(Request $request)
    {
        // return $request;
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'password' => 'required',
            'status' => 'required',
            'approved' => 'required',
            'goverment_id' => 'required',
        ];
        $this->validate($request, $rules);
        $message = 'Data inserted Successfully';

        $helper = new Helpers();
        $helper->name = $request->name;
        $helper->email = $request->email;
        $helper->mobile = $request->mobile;
        $helper->password = bcrypt($request->password);
        $helper->status = $request->status;
        $helper->approved = $request->approved;
        $helper->goverment_id = $request->goverment_id;
        $helper->save();

        Session::flash('success', $message);

        return redirect()->route('helperadd');
    }

    public function helper_update($id)
    {
        $helper = Helpers::find($id);
        $document = Document::select('id', 'id_no')->get();

        return view('helpers.update', compact('helper', 'document'));
    }

    public function helper_edit(Request $request, $id)
    {
        $helper = Helpers::find($id);
        $helper->name = $request->name;
        $helper->email = $request->email;
        $helper->mobile = $request->mobile;
        $helper->status = $request->status;
        $helper->approved = $request->approved;
        $helper->goverment_id = $request->goverment_id;
        $helper->update();

        return redirect()->route('helpers')->with('success', 'Helper has been Updated Successfully');
        // return $helper;
    }

    public function job_helpers_list($id)
    {
        $data['helpersjobs'] = JobHelpers::where('helper_id', $id)->with('job.checkout')->get();
        // return $data;
        return view('helpers.helper_job_list', $data);
    }

    public function job_helpers_status(Request $request)
    {
        // return $request;
        $job_status = Helpers::find($request->helper_id);
        $job_status->status = $request->status;
        $job_status->update();

        return response()->json(['message' => 'true']);
    }

    public function helper_document($id)
    {
        // return $id;
        $helper = Helpers::find($id);
        // return $helper;
        $document = Document::where('id', $helper->goverment_id)->get();
        // return $document;
        return view('helpers.helper_document', compact('document', 'helper'));
        // return $document;
        // return $helper->goverment_id;
    }

    public function hepler_document_status($id)
    {
        // return $id;
        $helper = Helpers::find($id);
        if ($helper->status == '1') {
            $helper->status = '0';
            $helper->save();

            return redirect()->back()->with('success', 'Helper  Inactive successfully!');
        } elseif ($helper->status == '0') {
            $helper->status = '1';
            $helper->save();

            return redirect()->back()->with('success', 'Helper  Active successfully!');
        }
    }

    public function earnings(Request $request)
    {
        $data['helpers'] = Helpers::with('jobs.job', 'earning')->get();
        // return $data;
        return view('helpers.earnings', $data);
    }
    public function helperEarningsDetails($id)
    {
        $helper_earning = HelperWallet::with('job')->where('helper_id', $id)->get();
        $helper_info = Helpers::find($id);
        // dd($helper_info);
        return view('helpers.earnings-details', compact('helper_earning','helper_info'));
    }
    //coded by arman
    public function helperEarningsPay(Request $request)
    {
        $helper_id = $request->helper_id;
        $checkout_id = $request->checkout_id;
        $total_amount = $request->total_amount;

        $earning_payment = new HelperEarningPayments();
        $earning_payment->helper_id = $helper_id;
        $earning_payment->checkout_id = $checkout_id;
        $earning_payment->amount = $total_amount;
        $earning_payment->save();
        $wallet_status = HelperWallet::where('checkout_id', $checkout_id)->first();
        $wallet_status->release_status = 'done';
        $wallet_status->update();
        return response()->json(['response' => true]);
    }
}
