<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['packages'] = Package::all();

        return view('packages.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('packages.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->rules());
        Package::forceCreate($request->except('_token'));

        return redirect()->route('packages.index')->with('success', 'Packages Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['package'] = Package::find($id);

        return view('packages.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $package = Package::find($id);
        $package->update($request->except(['_token']));

        return redirect()->route('packages.index')->with('success', 'Package Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Package::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Package Deleted Successfully');
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'status' => 'required',
         ];
    }

    public function package_status(Request $request)
    {
        $job_status = Package::find($request->package_id);
        $job_status->status = $request->status;
        $job_status->update();

        return response()->json(['message' => 'true']);
    }
}
