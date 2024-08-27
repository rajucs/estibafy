<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Container;
use App\Models\Package;
use App\Models\Job;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;


use App\Models\User;


use Session;
use Hash;
use DataTables;
use Mail;
use PDF;
use DB;
use Carbon\Carbon;


class ContainerController extends Controller
{

    public function package_types(Request $request )
    {
        $response['success']=200;
        $response['message']='';
        $response['error']=[];
        $response['data']=[
            'package_types' =>  Package::select('id','name')->where('status',1)->get(),
            'container_types' => Container::select('id','name','type','helper_size')->where('status',1)->get()
        ];
        return response()->json( $response );
    }


}
