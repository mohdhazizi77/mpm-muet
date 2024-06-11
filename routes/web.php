<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuditLogsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CandidateAuthController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CandidatesResultController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\FinanceModController;
use App\Http\Controllers\FinanceMuetController;
use App\Http\Controllers\FinanceStatementController;
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

Auth::routes();

Route::get('paymentstatus', [CandidateController::class, 'paymentstatus']);
Route::post('paymentstatus', [CandidateController::class, 'paymentstatus']);

Route::get('qrscan', [CandidateController::class, 'qrscan']);

//Language Translation
//Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('root');


Route::get('/admin/login',      [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login',     [AdminAuthController::class, 'login']);
Route::post('/admin/logout',    [AdminAuthController::class, 'logout'])->name('admin.logout');


Route::get('/candidate/login', [CandidateAuthController::class, 'showLoginForm'])->name('candidate.login');
Route::post('/candidate/login', [CandidateAuthController::class, 'login']);
Route::post('/candidate/logout', [CandidateAuthController::class, 'logout'])->name('candidate.logout');

Route::get('/template', [HomeController::class, 'template']);

//CALON
Route::group(['middleware' => ['auth:candidate','role:CALON']], function () {

    Route::get('/candidate', [CandidateController::class, 'index'])->name('candidate.index');
    Route::post('/candidate/ajax', [CandidateController::class, 'getAjax'])->name('candidate.getAjax');
    Route::post('/candidate/verifyIndexNumber', [CandidateController::class, 'verifyIndexNumber'])->name('candidate.verifyIndexNumber');

    Route::get('/candidate-downloadpdf/{id}', [CandidateController::class, 'downloadpdf'])->name('candidate.downloadpdf');
    Route::get('/candidate-selfprint/{id}', [CandidateController::class, 'selfprint'])->name('candidate.selfprint');
    Route::get('/candidate-printmpm/{id}', [CandidateController::class, 'printmpm'])->name('candidate.printmpm');

    Route::get('/order/{id}', [OrderController::class, 'index'])->name('order.index');
    Route::post('/order/ajax', [OrderController::class, 'getAjax'])->name('order.getAjax');
    Route::post('/track-order/ajax', [OrderController::class, 'getAjaxTrackOrder'])->name('order.getAjaxTrackOrder');

    Route::get('/muet-status/{id}', [CandidateController::class, 'muetstatus'])->name('candidate.muet-status');

    Route::post('/candidate-payment', [PaymentController::class, 'makepayment'])->name('candidate.makepayment');
    Route::get('/payment/getdata', [PaymentController::class, 'getpayment'])->name('candidate.getpayment');
    Route::post('/payment/getdata', [PaymentController::class, 'callbackpayment'])->name('candidate.callback');

    Route::get('/candidate/{id}/printpdf', [CandidateController::class, 'printpdf'])->name('candidate.printpdf');
});

Route::group(['middleware' => ['role:PENTADBIR|ADMIN|MOD|MUET|BPCOM|PSM']], function () {
// Route::group([], function () {

    // Route::resource('admin', AdminController::class);

    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    Route::get('/pos/token', [PosController::class, 'getBearerToken']);

    Route::get('/pos-management/{type}', [PosController::class, 'index'])->middleware('poslaju.token');
    Route::post('/pos/{type}/ajax', [PosController::class, 'getAjax']);
    Route::post('/pos/{type}/update', [PosController::class, 'update']);
    Route::post('/pos/{type}/bulk/update', [PosController::class, 'updateBulk']);
    Route::post('/pos/{type}/bulk/cancel', [PosController::class, 'cancelBulk']);
    Route::post('/pos/{type}/bulk/print', [PosController::class, 'printBulk']);
    Route::get('/pos/{type}/export-xlsx', [PosController::class, 'exportXlsx']);
    Route::get('/pos-management/{type}/getPosDetail', [PosController::class, 'getPosDetail']);
    Route::get('/pos-management/{type}/generateExcel', [PosController::class, 'generateExcel']);
    Route::get('/pos-management/{type}/generateExcelPos', [PosController::class, 'generateExcelPos']);

    Route::get('/your-route', function () {
        // Your route logic here
    })->middleware('poslaju.token');

    // download pdf
    Route::get('/pos/candidates-downloadpdf/{id}', [CandidateController::class, 'downloadpdf'])->name('mpm.downloadpdf');


    // Route::get('pos', [PosController::class, 'index'])->name('pos.index');
    // Route::post('pos/ajax', [PosController::class, 'getAjax'])->name('pos.ajax');
    // Route::get('pos/getPosDetail', [PosController::class, 'getPosDetail'])->name('pos.detail');

    // Route::resource('pos-new', PosNewController::class)->except('show');

    Route::resource('pos-processing', PosProcessingController::class)->except('show');
    // Route::post('pos-processing/ajax', [PosProcessingController::class, 'getAjax'])->name('pos-processing.ajax');
    // Route::get('pos-processing/export-xlsx', [PosProcessingController::class, 'exportXlsx']);
    // Route::get('pos-processing/export-pos-xlsx', [PosProcessingController::class, 'exportPosXlsx']);
    Route::get('pos-processing/print-certificate-pdf', [PosProcessingController::class, 'printPdf']);

    Route::resource('pos-completed', PosCompletedController::class)->except('show');
    // Route::post('pos-completed/ajax', [PosCompletedController::class, 'getAjax'])->name('pos-completed.ajax');
    // Route::get('pos-completed/export-xlsx', [PosCompletedController::class, 'exportXlsx']);

    Route::resource('finance', FinanceController::class);
    Route::post('finance/ajax', [FinanceController::class, 'getAjax'])->name('finance.ajax');

    Route::resource('finance-muet', FinanceMuetController::class);
    Route::post('finance-muet/ajax', [FinanceMuetController::class, 'getAjax'])->name('finance-muet.ajax');

    Route::resource('finance-mod', FinanceModController::class);
    Route::post('finance-mod/ajax', [FinanceModController::class, 'getAjax'])->name('finance-mod.ajax');

    Route::resource('finance-statement', FinanceStatementController::class);

    // Route::resource('transaction', TransactionController::class);
    // Route::get();
    Route::get('/transaction', [PaymentController::class, 'index'])->name('transaction.index');
    Route::post('/transaction/ajax', [PaymentController::class, 'getAjax'])->name('transaction.ajax');
//    Route::resource('report-transaction', ReportTransactionController::class);
//    Route::resource('report-financial', ReportFinancialController::class);

    // Route::resource('users', UserController::class);
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::post('users/ajax', [UserController::class, 'getAjax'])->name('users.ajax');
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/update/{user}', [UserController::class, 'update'])->name('users.update');

    Route::resource('audit-logs', AuditLogsController::class);
    Route::post('audit-logs/ajax', [AuditLogsController::class, 'getAjax'])->name('audit-logs.ajax');

});

//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

// Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
