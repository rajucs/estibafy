<?php

namespace App\Http\Controllers\API;

use App\Models\Helpers;

// use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\PaymentMehodCred;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use PDO;
use PharIo\Manifest\Extension;
use Illuminate\Support\Facades\Validator;


class GovermentController extends Controller
{

    public function index(Request $request)
    {
        $helper_id =   $request->user()->id;
        
        $users = $request->user();
        $document = new Document();
        $document->id_no = $request->id_no;
        $document->expire_date = $request->expire_date;
        // $image = $request->image;
        // $inquiry_image = "data:image/png;base64," . $image;

        // $data = [
        //   'image' => $inquiry_image,
        //   'medium' => '/assets/images/govermentImages/medium/',
        //   'orignal' => '/assets/images/govermentImages/orignal/',
        //   'thumbnail' => '/assets/images/govermentImages/thumbnail/',
        // ];
        
         if ($request->file('image')) {
              $file = $request->file('image');
              $image = time() . '_' . $file->getClientOriginalName();
              $file->move('helpers',  $image);
              $document->image = $image;
          }
        
        $document->save();
       
         
        $govt_docs_id =  $document->id;
        
        
        $a = Helpers::where('id',$helper_id )->update(array('goverment_id' => $govt_docs_id));

        
        return response()->json([
          'statusCode' => 200,
          'msg' => 'success',
        ]);
    }
    public function userGovIdAdd(Request $request)
    {
        $user_id =   $request->user()->id;
        
        $users = $request->user();
        $document = new Document();
        $document->id_no = $request->id_no;
        $document->expire_date = $request->expire_date;
        // $image = $request->image;
        // $inquiry_image = "data:image/png;base64," . $image;

        // $data = [
        //   'image' => $inquiry_image,
        //   'medium' => '/assets/images/govermentImages/medium/',
        //   'orignal' => '/assets/images/govermentImages/orignal/',
        //   'thumbnail' => '/assets/images/govermentImages/thumbnail/',
        // ];
        
         if ($request->file('image')) {
              $file = $request->file('image');
              $image = time() . '_' . $file->getClientOriginalName();
              $file->move('helpers',  $image);
              $document->image = $image;
          }
        
        $document->save();
       
         
        $govt_docs_id =  $document->id;
        
        
        $a = User::where('id',$user_id )->update(array('goverment_id' => $govt_docs_id));

        
        return response()->json([
          'statusCode' => 200,
          'msg' => 'success',
        ]);
    }

    public function add_payment_method(Request $request)
    {
        $rules = array(
            'name' => 'required',
            'stackholder_type' => 'required',
            'payment_method_id' => 'required',
            'card_no' => 'required',
            'expiry_date' => 'required',
            'cvv' => 'required',

        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(array(
                'success' => 400,
                'error' => $validator->errors(),
                'message' => '',
                'data' => [],
            ));
        }

        $payment = PaymentMehodCred::create([
            'name' => $request->name,
            'stackholder_id' =>   $request->user()->id,
            'stackholder_type' => $request->stackholder_type,
            'payment_method_id' => $request->payment_method_id,
            'card_no' =>   $request->card_no,
            'expiry_date' =>   $request->expiry_date,
            'cvv' =>   $request->cvv,
        ]);
        return response()->json([
            'statusCode' => 200,
            'msg' => 'success',
            "data" =>$payment
          ]);

    }

}
