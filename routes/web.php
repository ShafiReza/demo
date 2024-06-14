<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProviderController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'loginPost'])->name('loginPost');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/sales/generate', [SaleController::class, 'generate'])->name('sales');
Route::post('/sales/generate', [SaleController::class, 'generateSales'])->name('sales.generateSales');
Route::post('/day-end', [SaleController::class, 'dayEnd'])->name('day_end');

Route::get('/client', [ClientController::class, 'index'])->name('client.index');
Route::get('/client/create', [ClientController::class, 'create'])->name('client.create');
Route::post('/client', [ClientController::class, 'store'])->name('client.store');
Route::get('/client/{id}', [ClientController::class, 'show'])->name('client.show');

Route::get('client/{id}/receive-report', [ClientController::class, 'showReceiveReport'])->name('client.receive-report');
Route::get('client/{id}/sales-report', [ClientController::class, 'showSalesReport'])->name('client.sales-report');
Route::get('client/{id}/generate-report', [ClientController::class, 'generateReport'])->name('client.generate-report');
Route::delete('/payment/{id}', [PaymentController::class,'destroy'])->name('payment.delete');
 Route::delete('/payment/{id}', [PaymentController::class, 'destroy'])->name('payment.destroy');


Route::post('/client/filter', [ClientController::class, 'filter'])->name('client.filter');
Route::post('/client/{id}/toggle-status', [ClientController::class, 'toggleStatus'])->name('client.toggle-status');


Route::get('/clients/{client}/edit', [ClientController::class, 'edit'])->name('client.edit');
Route::put('/clients/{client}', [ClientController::class, 'update'])->name('client.update');

Route::post('/client/{id}/receive-payment', [ClientController::class, 'receivePayment'])->name('client.receive-payment');

Route::get('/client/{id}/receive-payment-form', [ClientController::class, 'receivePaymentform'])->name('client.receive-payment-form');
Route::get('/client/{id}/payment-history', [ClientController::class, 'paymentHistory'])->name('payment_history');

Route::post('/client/{id}/add-sales', [ClientController::class, 'addSales'])->name('client.add-sales');
Route::get('/client/{id}/add-sales-page', [ClientController::class, 'addSalesPage'])->name('client.add-sales-page');

Route::get('/payment/receive', [PaymentController::class, 'paymentReceive'])->name('payments.payment_receive');

Route::get('/payment/report', [SaleController::class, 'report'])->name('payment.report');
Route::post('/payment/filterPayment', [SaleController::class, 'filterPayments'])->name('payment.filterPayments');

Route::post('/payment/filter', [PaymentController::class,'filterPayments'])->name('payments.filterPayments');

Route::get('/provider/index', [ProviderController::class, 'index'])->name('provider.index');
Route::get('/provider/create', [ProviderController::class, 'create'])->name('provider.create');
Route::post('/provider', [ProviderController::class, 'store'])->name('provider.store');

Route::get('provider/{id}/receive-report', [ProviderController::class, 'showReceiveReport'])->name('provider.receive-report');
Route::get('provider/report', [ProviderController::class, 'showReport'])->name('provider.report');
Route::get('provider/{id}/transfer-report', [ProviderController::class, 'showTransferReport'])->name('provider.transfer-report');
Route::get('/provider/{id}/receive-payment-form', [ProviderController::class, 'receivePaymentForm'])->name('provider.receive-payment-form');

Route::post('/provider/{id}/receive-payment', [ProviderController::class, 'receivePayment'])->name('provider.receive-payment');

Route::post('/provider/{id}/toggle-status', [ProviderController::class, 'toggleStatus'])->name('provider.toggle-status');
Route::get('/providers/filter', [ProviderController::class, 'filter'])->name('providers.filter');
Route::post('/providers/filter', [ProviderController::class, 'filter'])->name('providers.filter');
Route::get('/provider/{id}/payment-history', [ProviderController::class, 'paymentHistory'])->name('provider.payment-history');


Route::get('/provider/{id}/receive-payment', [ProviderController::class, 'receivePayment'])->name('provider.receive-payment');
Route::post('/provider/{id}/receive-payment', [ProviderController::class, 'receivePayment'])->name('provider.receive-payment');
Route::get('/provider/transfer', [ProviderController::class, 'showTransferPage'])->name('provider.transfer');
Route::post('/provider/transfer', [ProviderController::class, 'transferFunds'])->name('provider.transfer-funds');
Route::delete('/provider/{id}', [ProviderController::class, 'destroy'])->name('provider.destroy');

Route::get('/change-password', [ChangePasswordController::class, 'index'])->name('change-password');
Route::post('/change-password', [ChangePasswordController::class, 'changePassword'])->name('change-password');
     Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');
});




