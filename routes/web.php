<?php

use Illuminate\Support\Facades\Route;

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

Route::admineticAuth();


Route::resource('payment', \Adminetic\Account\Http\Controllers\Admin\PaymentController::class);
Route::resource('transaction', \Adminetic\Account\Http\Controllers\Admin\TransactionController::class);
Route::resource('account', \Adminetic\Account\Http\Controllers\Admin\AccountController::class);
Route::resource('transfer', \Adminetic\Account\Http\Controllers\Admin\TransferController::class);
Route::resource('fiscal', \Adminetic\Account\Http\Controllers\Admin\FiscalController::class);

Route::view('entities-income-expense-subjects', 'account::admin.entities.income_expense_subjects')->name('admin.entities.income_expense_subjects');
Route::view('entities-ledger-accounts', 'account::admin.entities.ledger_accounts')->name('admin.entities.ledger_accounts');

// Reports
Route::view('chart-of-account', 'account::admin.report.chart_of_account')->name('admin.report.chart_of_account');
Route::view('ledger-summary', 'account::admin.report.ledger_summary')->name('admin.report.ledger_summary');
Route::view('transaction-report', 'account::admin.report.transaction_report')->name('admin.report.transaction_report');
Route::view('user-account-audit', 'account::admin.report.user_account_audit')->name('admin.report.user_account_audit');
Route::view('profit-loss-report', 'account::admin.report.profit_loss_report')->name('admin.report.profit_loss_report');
Route::view('cumulative-balance-report', 'account::admin.report.cumulative_balance_report')->name('admin.report.cumulative_balance_report');

Route::resource('ledger', \Adminetic\Account\Http\Controllers\Admin\LedgerController::class);
Route::resource('journal', \Adminetic\Account\Http\Controllers\Admin\JournalController::class);

Route::resource('entry', \Adminetic\Account\Http\Controllers\Admin\EntryController::class);
