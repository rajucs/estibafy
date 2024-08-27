<?php

namespace App\Http\Controllers;

use App\Models\AdminEarningPercentage;
use Illuminate\Http\Request;
use Session;

class AdminEarningController extends Controller
{
    public function index()
    {
        $admin_earning = AdminEarningPercentage::first();

        return view('admin_earning.index', compact('admin_earning'));
    }

    public function admin_earning_add()
    {
        return view('admin_earning.add');
    }

    public function admin_earning_insert(Request $request)
    {
        $rules = [
            'earning_percentage' => 'required',
        ];
        $this->validate($request, $rules);
        $message = 'Admin Earning Add Successfully';

        $adminearning = new AdminEarningPercentage();
        $adminearning->earning_percentage = $request->earning_percentage;
        $adminearning->save();
        Session::flash('success', $message);

        return redirect()->route('adminearningadd');
    }

    public function admin_earning_update($id)
    {
        $adminearning = AdminEarningPercentage::find($id);

        return view('admin_earning.update', compact('adminearning'));
    }

    public function admin_earning_edit(Request $request, $id)
    {
        $adminearning = AdminEarningPercentage::find($id);
        $adminearning->earning_percentage = $request->earning_percentage;
        $adminearning->update();

        return redirect()->route('adminearning')->with('success', 'Admin Earning has been Updated Successfully');
    }
}
