<?php

use App\Http\Controllers\API\HelperController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Helper;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\GovermentController;
use App\Http\Controllers\API\JobController;
use App\Http\Controllers\API\jobscount;
use App\Http\Controllers\APIController;
use App\Http\Controllers\JobsController;
use Illuminate\Routing\Route as RoutingRoute;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();

Route::match(array('get', 'post'), '/usersCreate/{id?}', 'APIController@usersCreate')->name('api.usersCreate');
Route::match(array('get', 'post'), '/login/{id?}', 'APIController@login')->name('api.login');
Route::match(array('get', 'post'), '/forgotPassword/{id?}', 'APIController@forgotPassword')->name('api.forgotPassword');
Route::match(array('get', 'post'), '/helperForgotPassword/{id?}', 'APIController@helperForgotPassword')->name('api.helperForgotPassword');

Route::match(array('get', 'post'), '/verifyOtp', 'APIController@verifyOtp')->name('api.verifyOtp');
Route::match(array('get', 'post'), '/resendOtp', 'APIController@resendOtp')->name('api.resendOtp');

Route::post('/fcmtoken/replaceAll', 'API\FCMController@replaceAllTokens');




// helper routes here
// Route::post(array('get', 'post'), '/helpersCreate/{id?}', 'HelperController@usersCreate')->name('helperCreate');
// Route::match(array('get', 'post'), '/helperslogin/{id?}', 'HelperController@login')->name('helperlogin');

Route::post('/helper/signup', [HelperController::class, 'usersCreate']);
Route::post('/helper/login', [HelperController::class, 'login']);
Route::post('/helper/verifyOtp', [HelperController::class, 'verifyOtp']);
Route::get('/helper/resendOtp', [HelperController::class, 'resendOtp']);
//language
Route::get('/lang', [APIController::class, 'languageSwitcher']);


Route::group(['prefix' => 'helper'], function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/profile', [HelperController::class, 'profile']);
        Route::get('/helperprofile', [HelperController::class, 'helperprofile']);
        Route::get('/jobs', [HelperController::class, 'jobscount']);
        Route::post('/detail/jobs', [HelperController::class, 'jobdetial']);
        Route::post('/job/action', [HelperController::class, 'jobactions']);
        Route::post('/job/action/status', [HelperController::class, 'jobstatus']);
        Route::post('/job/completed', [HelperController::class, 'job_completed']);
        Route::get('/job/earning', [HelperController::class, 'helper_earning']);
        Route::get('/stats', [HelperController::class, 'stats']);
        // goverment add
        Route::post('/submit/goverment', [GovermentController::class, 'index']);
        //job helper location set
        Route::post('/set/job/locations', [HelperController::class, 'set_helper_job_location']);
        //delete account
        Route::post('/account/delation', [HelperController::class, 'account_deletation']);
    });
});
//  helpers route end here

Route::group(array('middleware' => ['auth:sanctum']), function () {

    Route::match(array('get', 'post'), '/userDetails/{id?}', 'APIController@userDetails')->name('api.userDetails');
    Route::match(array('get', 'post'), '/usersUpdate/{id?}', 'APIController@usersUpdate')->name('api.usersUpdate');
    Route::match(array('post'), '/job/post', 'API\JobController@job_post')->name('api.job');
    Route::match(array('get'), '/cargo/types', 'API\ContainerController@package_types')->name('api.packageTypes');
    Route::match(array('post'), '/get/job/summary', 'API\JobController@job_summary')->name('api.jobSummary');
    Route::match(array('post'), '/job/checkout', 'API\JobController@job_checkout')->name('api.checkout');
    Route::match(array('get'), '/get/jobs', 'API\JobController@get_jobs')->name('api.jobs');
    // Route::match(array('get'), '/get/jobs/geo', 'API\JobController@getJobGeoData')->name('api.jobs');
    Route::match(array('get'), '/get/jobs/geo', 'API\JobController@getJobGeoData')->name('api.jobs.geo.get');
    Route::match(array('post'), '/set/jobs/geo', 'API\JobController@setJobGeoData')->name('api.jobs.geo.set');


    // Route::match(array('get'), '/booking/confirm', 'API\JobController@confirm')->name('api.jobs');
    Route::match(array('get'), '/get/helper/{id}', 'UserController@get_helper')->name('api.helperJobs');
    // rizwan routes
    Route::get('/job/detail/{id}', [JobController::class, 'JobDetail']);

    Route::post('/job/helper/status', [JobController::class, 'jobhelperstatus']);
    Route::get('/all/jobs', [JobController::class, 'alljobs']);

    Route::post('/payment_method', [GovermentController::class, 'add_payment_method']);

    //user fcm routes
    Route::group(['prefix' => 'fcmtoken'], function () {
        Route::post('/add', 'API\FCMController@addToken');
        Route::post('/revoke', 'API\FCMController@revokeToken');
        Route::get('/get', 'API\FCMController@getToken');
    });
    //invoices
    ROute::get('/invoices', [JobController::class, 'userInvoices'])->name('userInvoices');
    Route::post('/submit/usergoverment', [GovermentController::class, 'userGovIdAdd']);
    //delete user account
    Route::post('/account/delation', [JobController::class, 'account_deletation']);

    // company helper add
    Route::post('/company/helper-add', [APIController::class, 'CompanyHelperAdd']);
    Route::get('/company/helper-delete/{id}', [APIController::class, 'CompanyHelperDelete']);
    Route::get('/company/helpers', [APIController::class, 'CompanyHelpers']);
    Route::get('/company/jobs', [JobController::class, 'companyJobs']);
    Route::post('/company/job/accept', [JobController::class, 'companyJobAccept']);
    Route::post('/company/helpers/assign', [JobController::class, 'companyHelpersAssign']);
    Route::get('/company/wallet', [JobController::class, 'companyWallet']);
    Route::post('/company/helperrate', [JobController::class, 'updateHelperRate']);
});



//Route::group(array('middleware' => ['auth:sanction']), function () {
//
//    /*API's*/
//
//    Route::match(array('get','post'), '/userDetails/{id?}', 'APIController@userDetails')->name('api.userDetails');
//    Route::match(array('get','post'), '/usersCreate/{id?}', 'APIController@usersCreate')->name('api.usersCreate');
//    Route::match(array('get','post'), '/login/{id?}', 'APIController@login')->name('api.login');
//    Route::match(array('get','post'), '/forgotPassword/{id?}', 'APIController@forgotPassword')->name('api.forgotPassword');
//
//
//});

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
