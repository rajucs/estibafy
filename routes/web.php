<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;



// Route::get('lang/home', [LangController::class, 'index']);
Route::get('lang/change', [App\Http\Controllers\LangController::class, 'change'])->name('changeLang');



Route::get('/', function () {
    return redirect()->route('index');
})->name('/');

Route::match(['get', 'post'], '/', 'UserController@index')->name('index');
Route::match(['get', 'post'], '/', 'UserController@index')->name('login');

Route::match(['get', 'post'], '/sign_in', 'UserController@index')->name('sign_in');

/*confirm Account*/
Route::match(['get', 'post'], '/confirmAccount/{code?}', 'UserController@confirmAccount')->name('confirmAccount');

///*API's*/
//
//Route::match(array('get','post'), '/api/userDetails/{id?}', 'APIController@userDetails')->name('api.userDetails');
//Route::match(array('get','post'), '/api/usersCreate/{id?}', 'APIController@usersCreate')->name('api.usersCreate');
//Route::match(array('get','post'), '/api/login/{id?}', 'APIController@login')->name('api.login');
//Route::match(array('get','post'), '/api/forgotPassword/{id?}', 'APIController@forgotPassword')->name('api.forgotPassword');

Route::prefix('admin')->group(function () {
    Route::group(['middleware' => ['auth', 'CheckUserAccess']], function () {
        /*Dashobard*/
        Route::match(['get', 'post'], '/dashboard', 'DashboardController@index')->name('dashboard');

        /*Users*/
        Route::match(['get', 'post'], '/users', 'UserController@users')->name('users');
        Route::match(['get', 'post'], '/usersCreate/{id?}', 'UserController@usersCreate')->name('usersCreate');
        Route::match(['get', 'post'], '/userCheckEmail', 'UserController@userCheckEmail')->name('userCheckEmail');
        Route::match(['get', 'post'], '/usersUpdate/{id?}', 'UserController@usersCreate')->name('usersUpdate');
        Route::match(['get', 'post'], '/deleteUser/{id?}', 'UserController@deleteUser')->name('deleteUser');
        Route::match(['get', 'post'], '/settings', 'UserController@settings')->name('settings');
        Route::match(['get', 'post'], '/checkCurrentPassword', 'UserController@checkCurrentPassword')->name('checkCurrentPassword');

        /*User Roles*/
        Route::match(['get', 'post'], '/userRoles/{id?}', 'UserController@userRoles')->name('userRoles');
        Route::match(['get', 'post'], '/userRoleAccess/{id?}', 'UserController@userRoleAccess')->name('userRoleAccess');
        Route::match(['get', 'post'], '/deleteUserRoles/{id?}', 'UserController@deleteUserRoles')->name('deleteUserRoles');

        /*Sign OUt*/
        Route::match(['get', 'post'], '/sign_out', 'DashboardController@sign_out')->name('sign_out');

        /*Samples*/
        Route::match(['get', 'post'], '/Blank', 'DashboardController@Blank')->name('Blank');
        Route::match(['get', 'post'], '/DataTableSample', 'DashboardController@DataTableSample')->name('DataTableSample');
        Route::match(['get', 'post'], '/FormValidationSample', 'DashboardController@FormValidationSample')->name('FormValidationSample');

        // rizwan routes start from here
        Route::resource('companies', CompaniesController::class);
        Route::resource('susers', plateformUserController::class);

        Route::get('user/status/{id}', [App\Http\Controllers\CompaniesController::class, 'changeofferStatus'])->name('user.changestatus');
        Route::post('user/pyamentdays/{id}', [App\Http\Controllers\CompaniesController::class, 'addUpdateTotalDaysofPayment'])->name('user.addupdatedayspayment');

        Route::resource('packages', PackagesController::class);
        Route::get('package/{id}', [App\Http\Controllers\PackagesController::class, 'destroy'])->name('deletepckage');
        // afzal data
        Route::post('package/status', [App\Http\Controllers\PackagesController::class, 'package_status'])->name('packagestatus');

        Route::resource('payment_method', PaymentGateController::class);
        Route::get('paymentmethod/{id}', [App\Http\Controllers\PaymentGateController::class, 'destroy'])->name('deletepaymentmethod');

        Route::get('jobs', [App\Http\Controllers\JobsController::class, 'index'])->name('jobsdetail');
        Route::get('job/detail/{id}', [App\Http\Controllers\JobsController::class, 'job_detail'])->name('jobdetail');
        Route::get('job/helper/profile/{id}', [App\Http\Controllers\JobsController::class, 'helper_profile'])->name('helper_profile');
        Route::get('job/asset/{id}', [App\Http\Controllers\JobsController::class, 'job_asset'])->name('jobasset');
        Route::post('job/jobstatusbyadmin', [App\Http\Controllers\JobsController::class, 'job_status_by_admin'])->name('jobstatusbyadmin');
        Route::post('job/status', [App\Http\Controllers\JobsController::class, 'job_status'])->name('jobstatus');
        Route::post('job/helpers', [App\Http\Controllers\JobsController::class, 'job_helper'])->name('jobhelper');
        Route::get('job/asset_status/{id}', [App\Http\Controllers\JobsController::class, 'job_asset_status'])->name('helperassetstatus');
        //afzal route  Container
        Route::get('containers', [App\Http\Controllers\ContainersController::class, 'index'])->name('containers');
        Route::get('containers/add', [App\Http\Controllers\ContainersController::class, 'add'])->name('containersadd');
        Route::post('container/insert', [App\Http\Controllers\ContainersController::class, 'insert'])->name('containersinsert');
        Route::get('container/update/{id}', [App\Http\Controllers\ContainersController::class, 'update'])->name('containersupdate');
        //by ahsan    
        Route::get('container/delete/{id}', [App\Http\Controllers\ContainersController::class, 'delete_container'])->name('containersdelete');

        Route::post('container/edit/{id}', [App\Http\Controllers\ContainersController::class, 'edit'])->name('containersedit');
        Route::post('container/status', [App\Http\Controllers\ContainersController::class, 'container_status'])->name('containerstatus');
        //end afzal

        // 25-3-2022 afzal ahmed data start
        Route::get('basefair', [App\Http\Controllers\BaseFairController::class, 'index'])->name('basefair');
        Route::get('basefair/add', [App\Http\Controllers\BaseFairController::class, 'add'])->name('basefairadd');
        Route::post('basefair/insert', [App\Http\Controllers\BaseFairController::class, 'insert'])->name('basefairinsert');
        Route::get('basefair/update/{id}', [App\Http\Controllers\BaseFairController::class, 'update'])->name('basefairupdate');
        Route::post('basefair/edit/{id}', [App\Http\Controllers\BaseFairController::class, 'edit'])->name('basefairedit');
        // 25-3-2022 afzal ahmed data end
        Route::get('jobs', [App\Http\Controllers\JobsController::class, 'index'])->name('jobsdetail');
        Route::get('job/detail/{id}', [App\Http\Controllers\JobsController::class, 'job_detail'])->name('jobdetail');
        Route::get('job/helper/profile/{id}', [App\Http\Controllers\JobsController::class, 'helper_profile'])->name('helper_profile');

        Route::get('jobdelete/{id}', [App\Http\Controllers\JobsController::class, 'destroy'])->name('jobdelete');

        // helpers controller

        Route::get('helpers/list', [App\Http\Controllers\HelpersController::class, 'index'])->name('helpers');
        Route::get('helper/add', [App\Http\Controllers\HelpersController::class, 'helper_add'])->name('helperadd');
        Route::post('helper/insert', [App\Http\Controllers\HelpersController::class, 'helper_insert'])->name('helperinsert');
        Route::get('helper/update/{id}', [App\Http\Controllers\HelpersController::class, 'helper_update'])->name('helperupdate');
        Route::post('helper/edit/{id}', [App\Http\Controllers\HelpersController::class, 'helper_edit'])->name('helperedit');
        Route::get('helpers/job/list/{id}', [App\Http\Controllers\HelpersController::class, 'job_helpers_list'])->name('helperlist');
        Route::get('helpers/document/list/{id}', [App\Http\Controllers\HelpersController::class, 'helper_document'])->name('helperdocument');
        Route::post('helper/status', [App\Http\Controllers\HelpersController::class, 'job_helpers_status'])->name('helperstatus');
        Route::get('helper/status_document/{id}', [App\Http\Controllers\HelpersController::class, 'hepler_document_status'])->name('helperdocumentstatus');
        //helpers earnings
        Route::get('helpers/earnings', [App\Http\Controllers\HelpersController::class, 'earnings'])->name('helpers-earning');
        Route::get('helpers/earnings-details/{id}', [App\Http\Controllers\HelpersController::class, 'helperEarningsDetails'])->name('healperEarningDetails');
        Route::post('helpers/payment', [App\Http\Controllers\HelpersController::class, 'helperEarningsPay'])->name('healperEarningPay');
        // invoices
        Route::get('invoices', [App\Http\Controllers\InvoiceController::class, 'index'])->name('invoices');
        Route::get('invoices-details/{id}', [App\Http\Controllers\InvoiceController::class, 'invoiceDetails'])->name('invoiceDetails');

        // reports
        Route::get('reports', [App\Http\Controllers\AdminReports::class, 'index'])->name('admin.reports');

        // Tax
        Route::get('tax', [App\Http\Controllers\TaxController::class, 'index'])->name('tax');
        Route::get('tax/add', [App\Http\Controllers\TaxController::class, 'tax_add'])->name('taxadd');
        Route::post('tax/insert', [App\Http\Controllers\TaxController::class, 'tax_insert'])->name('taxinsert');
        Route::get('tax/update/{id}', [App\Http\Controllers\TaxController::class, 'tax_update'])->name('taxupdate');
        Route::post('tax/edit/{id}', [App\Http\Controllers\TaxController::class, 'tax_edit'])->name('taxedit');

        // Admin Earning
        Route::get('adminearning', [App\Http\Controllers\AdminEarningController::class, 'index'])->name('adminearning');
        Route::get('adminearning/add', [App\Http\Controllers\AdminEarningController::class, 'admin_earning_add'])->name('adminearningadd');
        Route::post('adminearning/insert', [App\Http\Controllers\AdminEarningController::class, 'admin_earning_insert'])->name('adminearninginsert');
        Route::get('adminearning/update/{id}', [App\Http\Controllers\AdminEarningController::class, 'admin_earning_update'])->name('adminearningupdate');

        Route::post('adminearning/edit/{id}', [App\Http\Controllers\AdminEarningController::class, 'admin_earning_edit'])->name('adminearningedit');
        //languges settings
        // Route::get('languages', [App\Http\Controllers\LanguagesController::class,'index'])->name('languages');
        Route::resource('languages', LanguagesController::class);
    });
});

Route::get('/clear-cache', function () {
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');

    return 'Cache is cleared';
})->name('clear.cache');

Route::get(
    'cacheClear',
    function () {
        \Artisan::call('config:cache');
        \Artisan::call('cache:clear');
        \Artisan::call('config:clear');
        \Artisan::call('route:clear');
        \Artisan::call('view:clear');
        \Artisan::call('optimize:clear');
        \Artisan::call('event:clear');
        \Artisan::call('event:cache');

        Session::flash('success_message', 'Event cache , Routes cache , Config cache , Config Clear,  View Clear , Optimize Clear , Event Clear , Cache cleared');

        return redirect()->back();

        //        return redirect()->route('dashboard');

        //        return 'Event cache , Routes cache , Config cache , Config Clear,  View Clear , Optimize Clear , Event Clear , Cache cleared';
    }
)->name('cacheClear');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
