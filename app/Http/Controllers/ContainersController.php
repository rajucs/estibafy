<?php

namespace App\Http\Controllers;

use App\Models\Container;
use DB;
use Illuminate\Http\Request;
use Session;

class ContainersController extends Controller
{
    public function index()
    {
        $data = Container::all();

        return view('container.index')->with('containers', $data);
    }

    public function add()
    {
        return view('container.add');
    }

    public function insert(Request $request)
    {
        $rules = [
            'name' => 'required',
            'helper_size' => 'required',
            'type' => 'required',
            'size' => 'required',
            'status' => 'required',
        ];
        $this->validate($request, $rules);
        $message = 'Data inserted Successfully';
        $container = new Container();

        // DB::beginTransaction();

        $container->name = $request->name;
        $container->helper_size = $request->helper_size;
        $container->type = $request->type;
        $container->size = $request->size;
        $container->status = $request->status;
        $container->save();
        // DB::commit();
        Session::flash('success_message', $message);

        // return redirect()->route('containersadd');
        return redirect()->route('containers')->with('success', 'Container Added Successfully');

    }

    public function update($id)
    {
        // return $id;
        $container = Container::find($id);
        

        return view('container.update')->with('container', $container);
    }

    public function edit(Request $request, $id)
    {
        $container = Container::find($id);
        $container->name = $request->name;

        $container->helper_size = $request->helper_size;
        $container->type = $request->type;
        $container->size = $request->size;
        $container->status = $request->status;
        $container->update();

        return redirect()->route('containers')->with('success', 'Container has been Updated Successfully');
    }

    public function container_status(Request $request)
    {
        $job_status = Container::find($request->container_id);
        $job_status->status = $request->status;
        $job_status->update();

        return response()->json(['message' => 'true']);
    }
    
    public function delete_container($id)
    {
       
        $container=Container::where('id',$id)->delete();


        return redirect()->route('containers')->with('success', 'Container Deleted Successfully');
    }
    
    
}
