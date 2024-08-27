<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use Illuminate\Http\Request;
use Session;

class TaxController extends Controller
{
    public function index()
    {
        $tax = Tax::first();

        return view('tax.index')->with('tax', $tax);
    }

    public function tax_add()
    {
        return view('tax.add');
    }

    public function tax_insert(Request $request)
    {
        $rules = [
            'tax_percentage' => 'required',
        ];
        $this->validate($request, $rules);
        $message = 'Tax Add Successfully';

        $tax = new Tax();
        $tax->tax_percentage = $request->tax_percentage;
        $tax->save();
        Session::flash('success', $message);

        return redirect()->route('taxadd');
    }

    public function tax_update($id)
    {
        $tax = Tax::find($id);

        return view('tax.update', compact('tax'));
    }

    public function tax_edit(Request $request, $id)
    {
        $tax = Tax::find($id);
        $tax->tax_percentage = $request->tax_percentage;
        $tax->update();

        return redirect()->route('tax')->with('success', 'Tax has been Updated Successfully');
    }
}
