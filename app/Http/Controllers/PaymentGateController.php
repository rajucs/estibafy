<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentGateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $data['payment_methods'] = PaymentMethod::all();
       return view('payment_method.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('payment_method.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->rules());
        PaymentMethod::forceCreate($request->except('_token'));

        return redirect()->route('payment_method.index')->with('success', 'payment_method Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['payment_method'] = PaymentMethod::find($id);
        return view('payment_method.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $package = PaymentMethod::find($id);
        $package->update($request->except(['_token']));
        return redirect()->route('payment_method.index')->with('success', 'payment method Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PaymentMethod::where('id', $id)->delete();
        return redirect()->back()->with('success', 'payment_method Deleted Successfully');
    }


    public function rules()
    {
        return [
            'name' => 'required',
            'secret_key' => 'required',
            'url' => 'required',
            'status' => 'required',
         ];
    }
}
