<?php

namespace App\Http\Controllers;

use App\Models\BaseFire;
use Illuminate\Http\Request;
use Session;

class BaseFairController extends Controller
{
    public function index()
    {
        $base_fair = BaseFire::first();

        return view('basefair.index')->with('base_fair', $base_fair);
    }

    public function add()
    {
        return view('basefair.add');
    }

    public function insert(Request $request)
    {
        $rules = [
            'base_fire' => 'required',
        ];
        $this->validate($request, $rules);
        $message = 'Base Fair Add Successfully';

        $basefair = new BaseFire();
        $basefair->base_fare = $request->base_fire;
        $basefair->save();
        Session::flash('success', $message);

        return redirect()->route('basefairadd');
    }

    public function update($id)
    {
        // return $id;
        $basefair = BaseFire::find($id);

        return view('basefair.update')->with('basefair', $basefair);
    }

    public function edit(Request $request, $id)
    {
        $basefair = BaseFire::find($id);
        $basefair->base_fare = $request->base_fire;
        $basefair->update();

        return redirect()->route('basefair')->with('success', 'Container has been Updated Successfully');
    }
}
