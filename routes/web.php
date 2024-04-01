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
use App\Http\Controllers\ReportFinancialController;
use App\Http\Controllers\ReportTransactionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
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

//Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::get('/candidate/login', [CandidateAuthController::class, 'showLoginForm'])->name('candidate.login');
Route::post('/candidate/login', [CandidateAuthController::class, 'login']);
Route::post('/candidate/logout', [CandidateAuthController::class, 'logout'])->name('candidate.logout');


//CALON
//Route::prefix('candidate')->group(function () {
Route::group(['middleware' => ['role:CANDIDATE']], function () {

//        Route::get('index', [App\Http\Controllers\CandidateController::class, 'index'])->name('/calon/keputusan');

//    Route::get('candidate', [App\Http\Controllers\CandidateController::class, 'index'])->name('candidate');
    Route::get('candidates-printpdf', [CandidateController::class, 'printpdf'])->name('candidates.printpdf');
    Route::get('candidates-downloadpdf', [CandidateController::class, 'downloadpdf'])->name('candidates.downloadpdf');
    Route::get('candidates-payment', [CandidateController::class, 'payment'])->name('candidates.payment');
    Route::get('muet-status', [CandidateController::class, 'muetstatus'])->name('candidates.muet-status');

    Route::get('candidates-printmpm', [CandidateController::class, 'printmpm'])->name('candidates.printmpm');
    Route::resource('candidates', CandidateController::class);

});

Route::group(['middleware' => ['role:ADMIN|MOD|MUET|BPCOM|PSM']], function () {

    Route::resource('admin', AdminController::class);

    Route::resource('pos-new', PosNewController::class)->except('show');
    Route::post('pos-new/ajax', [PosNewController::class, 'getAjax'])->name('pos-new.ajax');
    Route::get('pos-new/export-xlsx', [PosNewController::class, 'exportXlsx']);


    Route::resource('pos-processing', PosProcessingController::class)->except('show');
    Route::post('pos-processing/ajax', [PosProcessingController::class, 'getAjax'])->name('pos-processing.ajax');
    Route::get('pos-processing/export-xlsx', [PosProcessingController::class, 'exportXlsx']);
    Route::get('pos-processing/export-pos-xlsx', [PosProcessingController::class, 'exportPosXlsx']);
    Route::get('pos-processing/print-certificate-pdf', [PosProcessingController::class, 'printPdf']);


    Route::resource('pos-completed', PosCompletedController::class)->except('show');
    Route::post('pos-completed/ajax', [PosCompletedController::class, 'getAjax'])->name('pos-completed.ajax');
    Route::get('pos-completed/export-xlsx', [PosCompletedController::class, 'exportXlsx']);

    Route::resource('finance', FinanceController::class);
    Route::post('finance/ajax', [FinanceController::class, 'getAjax'])->name('finance.ajax');

    Route::resource('finance-muet', FinanceMuetController::class);
    Route::post('finance-muet/ajax', [FinanceMuetController::class, 'getAjax'])->name('finance-muet.ajax');

    Route::resource('finance-mod', FinanceModController::class);
    Route::post('finance-mod/ajax', [FinanceModController::class, 'getAjax'])->name('finance-mod.ajax');

    Route::resource('finance-statement', FinanceStatementController::class);

    Route::resource('transaction', TransactionController::class);
    Route::post('transaction/ajax', [TransactionController::class, 'getAjax'])->name('transaction.ajax');
//    Route::resource('report-transaction', ReportTransactionController::class);
//    Route::resource('report-financial', ReportFinancialController::class);

    Route::resource('users', UserController::class);
    Route::post('users/ajax', [UserController::class, 'getAjax'])->name('users.ajax');

    Route::resource('audit-logs', AuditLogsController::class);
    Route::post('audit-logs/ajax', [AuditLogsController::class, 'getAjax'])->name('audit-logs.ajax');

});
//});

//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
