<?php

namespace App\Http\Controllers;

use App\Models\Checkout;
use Illuminate\Http\Request;

class AdminReports extends Controller
{
    public function index(Request $request)
    {
        $data['jobs'] = Checkout::with('job.container')->where('status','complete')->get();

        $data['tax'] = Checkout::where('status','complete')->sum('tax');
        $data['totadssdsdl'] = Checkout::where('status','complete')->sum('total');
        $data['sub_total'] = Checkout::where('status','complete')->sum('sub_total');
        //return $data;
         return view('reports.admin_reports', $data);
    }

}
