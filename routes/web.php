<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('customers', CustomerController::class);
Route::get('customers/{customer}/statement', [CustomerController::class, 'statement'])->name('customers.statement');

Route::resource('subscriptions', SubscriptionController::class)->except(['show']);
Route::post('subscriptions/{subscription}/activate', [SubscriptionController::class, 'activate'])->name('subscriptions.activate');
Route::post('subscriptions/{subscription}/generate-invoice', [SubscriptionController::class, 'generateInvoice'])->name('subscriptions.generate-invoice');

Route::resource('invoices', InvoiceController::class)->only(['index', 'show']);
Route::post('invoices/{invoice}/pay', [InvoiceController::class, 'pay'])->name('invoices.pay');
