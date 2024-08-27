<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Models\Checkout;
use App\Models\Document;
use App\Models\HelperEarningPayments;
use App\Models\Helpers;
use App\Models\JobHelpers;
use App\Models\Job;
use App\Models\HelperWallet;
use Illuminate\Http\Request;
use Session;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $data['orders'] = Checkout::where('status', 'complete')->get();
        // return $data;
        // dd($data);
        return view('invoices.index', $data);
    }
    public function invoiceDetails($id)
    {
        $data['jobs'] = Job::with('user', 'user.company', 'checkout', 'job_helpers.helper_profile')->find($id);
        // return $data;
        // dd($data);
        return view('invoices.details', $data);
    }
}
