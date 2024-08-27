<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\fcmRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Helpers;


class FCMController extends Controller
{
    function addToken(Request $request)
    {
        $user=$request->user();
        $data=$request->all();
        $user->fcm_token=$data['fcm_token'];
        $status=$user->update();
        return response(["saved_status"=>$status,"validation_errors"=>null],200);
    }
    function getToken(Request $request)
    {
        $user=$request->user();
        if($user->fcm_token==null)
        {
            return response(["fcm_token"=>null,"validation_errors"=>'no fcm token for user'],200);
        }
        else
        {
            return response(["fcm_token"=>$user->fcm_token,"validation_errors"=>null],200);
        }
    }
    function revokeToken(Request $request)
    {
        $user=$request->user();
        $user->fcm_token=null;
        $user->update();
        return response(["fcm_token_revoked"=>true],200);
    }
    
    function replaceAllTokens(Request $request)
    {
        $users=User::all();
        $helpers=Helpers::all();
        $data=$request->all();
        $fcm_token=$data['fcm_token'];
        foreach($users as $user){
            $user->fcm_token=$fcm_token;
            $user->save();
        }
        foreach($helpers as $helper){
            $helper->fcm_token=$fcm_token;
            $helper->save();
        }
        return response(["saved_status"=>true,"validation_errors"=>null],200);
    }
}
