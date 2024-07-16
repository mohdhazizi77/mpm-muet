<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuditLogsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CandidateAuthController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CandidatesResultController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\FinanceModController;
use App\Http\Controllers\FinanceMuetController;
use App\Http\Controllers\FinanceStatementController;
use App\Http\Controllers\GeneralSettingController;
use App\Http\Controllers\PosCompletedController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\PosNewController;
use App\Http\Controllers\PosProcessingController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportFinancialController;
use App\Http\Controllers\ReportTransactionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ConfigPoslajuController;
use App\Http\Controllers\ConfigMpmBayarController;


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('root');
Route::get('/', function () {
    if (Auth::guard('candidate')->check()) {
        // return redirect('/home'); // Redirect authenticated users to the home page
        return redirect()->route('candidate.index');
    } else {
        // return view('auth.login'); // Display the login page for non-authenticated users
        return view('auth.candidate-login');
    }
})->name('root');

Auth::routes();

Route::get('paymentstatus', [CandidateController::class, 'paymentstatus']);
Route::post('paymentstatus', [CandidateController::class, 'paymentstatus']);

Route::get('qrscan', [CandidateController::class, 'qrscan']);

//Language Translation
//Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);



Route::get('/admin/login',      [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login',     [AdminAuthController::class, 'login']);
Route::post('/admin/logout',    [AdminAuthController::class, 'logout'])->name('admin.logout');


Route::get('/candidate/login', [CandidateAuthController::class, 'showLoginForm'])->name('candidate.login');
Route::post('/candidate/login', [CandidateAuthController::class, 'login']);
Route::post('/candidate/logout', [CandidateAuthController::class, 'logout'])->name('candidate.logout');

Route::get('/template', [HomeController::class, 'template']);

//CALON
Route::group(['middleware' => ['auth:candidate','role:CALON']], function () {

    Route::prefix('candidate')->group(function () {
        Route::get('/', [CandidateController::class, 'index'])->name('candidate.index');
        Route::post('/ajax', [CandidateController::class, 'getAjax'])->name('candidate.getAjax');
        Route::post('/verifyIndexNumber', [CandidateController::class, 'verifyIndexNumber'])->name('candidate.verifyIndexNumber');
        Route::get('/view-result/{id}', [CandidateController::class, 'printpdf'])->name('candidate.printpdf');
        Route::get('/download-result/{id}', [CandidateController::class, 'downloadpdf'])->name('candidate.downloadpdf');
        Route::get('/download-result-candidate/{id}/{type}', [CandidateController::class, 'downloadpdfCandidate'])->name('candidate.downloadpdfCandidate');
        Route::get('/pos-result/{id}', [CandidateController::class, 'printmpm'])->name('candidate.printmpm');
        Route::get('/selfprint/{id}', [CandidateController::class, 'selfprint'])->name('candidate.selfprint');
        Route::post('/payment', [PaymentController::class, 'makepayment'])->name('candidate.makepayment');
        Route::get('/order/{id}', [OrderController::class, 'index'])->name('order.index');
        Route::post('/order/ajax', [OrderController::class, 'getAjax'])->name('order.getAjax');
        Route::post('/track-order/ajax', [OrderController::class, 'getAjaxTrackOrder'])->name('order.getAjaxTrackOrder');
        Route::post('/track-shipping/ajax', [OrderController::class, 'getAjaxTrackShipping'])->name('order.getAjaxTrackShipping')->middleware('poslaju.token');
        Route::get('/muet-status/{id}', [CandidateController::class, 'muetstatus'])->name('candidate.muet-status');
        Route::post('/log-download', [CandidateController::class, 'logDownload'])->name('log.download');

    });
    Route::get('/payment/getdata', [PaymentController::class, 'getpayment'])->name('candidate.getpayment');
    Route::post('/payment/getdata', [PaymentController::class, 'callbackpayment'])->name('candidate.callback');
});

Route::group(['middleware' => ['role:PENTADBIR|BPKOM|PSM|FINANCE']], function () {

    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/dashboard-muet-pie-chart', [AdminController::class, 'muetPieChart'])->name('admin.muet_pie_chart');
        Route::get('/dashboard-mod-pie-chart', [AdminController::class, 'modPieChart'])->name('admin.mod_pie_chart');
        Route::get('/dashboard-line-chart', [AdminController::class, 'lineChart'])->name('admin.line_chart');

        Route::get('/pos-management/{type}', [PosController::class, 'index'])->middleware('poslaju.token');
        Route::get('/pos-management/{type}/getPosDetail', [PosController::class, 'getPosDetail']);
        Route::post('/pos-management/{type}/generateExcel', [PosController::class, 'generateExcel']);
        Route::post('/pos-management/{type}/generateExcelPos', [PosController::class, 'generateExcelPos']);
        Route::post('/pos-management/{type}/generateImportExcelPos', [PosController::class, 'generateImportExcelPos']);

        // Route::get('/transaction', [PaymentController::class, 'index'])->name('transaction.index');
        // Route::post('/transaction/ajax', [PaymentController::class, 'getAjax'])->name('transaction.ajax');
        // Route::post('/transaction/check', [PaymentController::class, 'checkpayment'])->name('transaction.check');
        // Route::get('/transaction/excel', [PaymentController::class, 'generateExcel'])->name('transaction.excel');
        // Route::get('/transaction/pdf', [PaymentController::class, 'generatePdf'])->name('transaction.pdf');

        Route::get('/transaction', [OrderController::class, 'indexAdmin'])->name('transaction.index');
        Route::post('/transaction/ajax', [OrderController::class, 'getAjaxAdmin'])->name('transaction.ajax');
        Route::post('/transaction/check', [OrderController::class, 'checkpaymentAdmin'])->name('transaction.check');
        Route::get('/transaction/excel', [OrderController::class, 'generateExcelAdmin'])->name('transaction.excel');
        Route::get('/transaction/pdf', [OrderController::class, 'generatePdfAdmin'])->name('transaction.pdf');

        Route::get('/finance/{exam_type}', [FinanceController::class, 'index'])->name('finance.index');
        Route::post('/finance/{exam_type}/ajax', [FinanceController::class, 'getAjax'])->name('finance.ajax');
        Route::post('/finance/{exam_type}/data', [FinanceController::class, 'getData'])->name('finance.data');
        Route::get('/finance/{exam_type}/pdf', [FinanceController::class, 'generatePdf'])->name('finance.pdf');

        Route::get('finance-statement', [FinanceStatementController::class, 'index'])->name('finance-statement.index');
        Route::get('finance-statement/download-pdf', [FinanceStatementController::class, 'downloadExcel'])->name('finance-statement.download_excel');

        // Route::resource('finance/muet', FinanceMuetController::class);
        // Route::post('finance/muet/ajax', [FinanceMuetController::class, 'getAjax'])->name('finance-muet.ajax');

        // Route::resource('finance/mod', FinanceModController::class);
        // Route::post('finance/mod/ajax', [FinanceModController::class, 'getAjax'])->name('finance-mod.ajax');

        Route::get('/general-setting', [GeneralSettingController::class, 'index'])->name('general_setting.index');
        Route::post('/general-setting/store', [GeneralSettingController::class, 'store'])->name('general_setting.store');


        Route::post('/courier/ajax', [CourierController::class, 'getAjax'])->name('courier.ajax');
        Route::post('/courier/store', [CourierController::class, 'store'])->name('courier.store');
        Route::post('/courier/update/{id}', [CourierController::class, 'update'])->name('courier.update');
        Route::delete('/courier/destroy/{id}', [CourierController::class, 'destroy'])->name('courier.destroy');

        Route::get('/config-poslaju', [ConfigPoslajuController::class, 'index'])->name('config_poslaju.index');
        Route::post('/config-poslaju/update-or-create', [ConfigPoslajuController::class, 'updateOrCreate'])->name('config_poslaju.update');

        Route::get('/config-mpmbayar', [ConfigMpmBayarController::class, 'index'])->name('config.mpmbayar.index');
        Route::post('/config-mpmbayar', [ConfigMpmBayarController::class, 'updateOrCreate'])->name('config.mpmbayar.update');

        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users/ajax', [UserController::class, 'getAjax'])->name('users.ajax');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
        Route::post('/users/update/{user}', [UserController::class, 'update'])->name('users.update');
        Route::post('/users/actived/{user}', [UserController::class, 'activated'])->name('users.activated');
        Route::post('/users/deactived/{user}', [UserController::class, 'deactived'])->name('users.deactived');

        Route::resource('/audit-logs', AuditLogsController::class);
        Route::post('/audit-logs/ajax', [AuditLogsController::class, 'getAjax'])->name('audit-logs.ajax');
    });

    Route::get('/pos/token', [PosController::class, 'getBearerToken']);
    Route::post('/pos/{type}/ajax', [PosController::class, 'getAjax']);
    Route::post('/pos/{type}/update', [PosController::class, 'update']);
    Route::post('/pos/{type}/cancel', [PosController::class, 'cancel']);
    Route::post('/pos/{type}/bulk/update', [PosController::class, 'updateBulk']);
    Route::post('/pos/{type}/bulk/cancel', [PosController::class, 'cancelBulk']);
    Route::post('/pos/{type}/bulk/print', [PosController::class, 'printBulk']);
    Route::get('/pos/{type}/export-xlsx', [PosController::class, 'exportXlsx']);

    // download pdf
    Route::get('/pos/downloadpdf/{id}', [CandidateController::class, 'singleDownloadPdf'])->name('mpm.singledownloadpdf');
    Route::post('/pos/bulkdownloadpdf', [CandidateController::class, 'bulkDownloadPdf'])->name('mpm.bulkdownloadpdf');
    Route::post('/pos/bulkdownloadconnote', [PosController::class, 'bulkDownloadConnote'])->name('mpm.bulkdownloadconnote');
});

Route::get('users/verify-password/{id}', [UserController::class, 'verifyIndex'])->name('users.verify_index');
Route::post('users/verify-password/{id}/update', [UserController::class, 'updatePassword'])->name('users.verify_index_update');
Route::post('users/verify-email', [UserController::class, 'verifyEmail'])->name('users.verify_email');

//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

// Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

Route::get('/verify/result/{id}', [CandidateController::class, 'verifyResult'])->name('verify.result');

