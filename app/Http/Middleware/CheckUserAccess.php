<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\UserModule;
use App\Models\UserRoles;
use App\Models\UserAccessManages;
use Session;
use Illuminate\Support\Facades\Auth;

class CheckUserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {

            return redirect('admin');

        }
        else {

            $admin_type = Auth::user()->user_type;

//            echo $admin_type;
//            echo "<BR>";
//            exit;



            $userModulesArr = UserModule::get()->toArray();

//           echo "<pre>";
//           print_r($userModulesArr);
//           echo "<BR>";
//           exit;

            if ($admin_type == 1) {


                if (!empty($userModulesArr)) {
                    foreach ($userModulesArr as $userModulesAr) {

                        $userModulesAr_id = $userModulesAr['id'];
                        $userModulesAr_module_slug = $userModulesAr['module_slug'];

//                        echo $userModulesAr_module_slug;
//                        echo "<BR>";

                        $UserAccessManagesCount = UserAccessManages::where('user_role_id', $admin_type)->where('module_id', $userModulesAr_id)->count();
//                        echo $UserAccessManagesCount;
//                        echo "<BR>";
//               exit;
                        if ($UserAccessManagesCount > 0) {
                            $userAccessArr[$userModulesAr_module_slug] = 1;
                        } else {
                            $userAccessArr[$userModulesAr_module_slug] = 0;

                        }

                        Session::put('userAccessArr', $userAccessArr);


                    }

                }

//                    echo "<PRE>";
//                    print_r($userAccessArr);
//                    exit;


//exit;



            }
            else {

                if (!empty($userModulesArr)) {
                    foreach ($userModulesArr as $userModulesAr) {

                        $userModulesAr_id = $userModulesAr['id'];
                        $userModulesAr_module_slug = $userModulesAr['module_slug'];

                        $userAccessArr[$userModulesAr_module_slug] = 1;

                        Session::put('userAccessArr', $userAccessArr);

                    }
                }
            }


//            $data = Session::all();
//            echo "<PRE>";
//            print_r($userAccessArr);
//            exit;

        }

        return $next($request);


    }
}
