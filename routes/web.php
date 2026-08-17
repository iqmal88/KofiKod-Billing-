<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompanySettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ChangeRequestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/login');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    
    // Change Requests
    Route::resource('change-requests', ChangeRequestController::class);

    Route::patch(
        '/change-requests/{changeRequest}/approve',
        [ChangeRequestController::class, 'approve']
    )->name('change-requests.approve');

    // Company Settings
    Route::get('/company-settings', [CompanySettingController::class, 'index'])
    ->name('company-settings.index');

    Route::put('/company-settings', [CompanySettingController::class, 'update'])
        ->name('company-settings.update');

    // Clients
    Route::resource('clients', ClientController::class);

    // Quotations
    Route::resource('quotations', QuotationController::class);
    Route::get('/quotations/{quotation}/pdf', [QuotationController::class, 'downloadPdf'])
    ->name('quotations.pdf');
    // Invoices
    Route::prefix('invoices')->name('invoices.')->group(function () {

    Route::get('/', [InvoiceController::class,'index'])
        ->name('index');

    Route::get('/quotation/{quotation}/generate', [InvoiceController::class,'generate'])
        ->name('generate');

    Route::post('/quotation/{quotation}', [InvoiceController::class,'store'])
        ->name('store');

    Route::get('/{invoice}', [InvoiceController::class,'show'])
        ->name('show');

    Route::patch('/{invoice}/paid', [InvoiceController::class,'markAsPaid'])
        ->name('paid');

    Route::get('/{invoice}/pdf', [InvoiceController::class,'downloadPdf'])
        ->name('pdf');
    
    Route::delete('/{invoice}',[InvoiceController::class, 'destroy'])
        ->name('destroy');

});
    /*
    |--------------------------------------------------------------------------
    | Receipts
    |--------------------------------------------------------------------------
    */

    // Receipt List
    Route::get(
        '/receipts',
        [ReceiptController::class, 'index']
    )->name('receipts.index');


    // Record Payment / Create Receipt
    Route::get(
        '/invoices/{invoice}/receipt/create',
        [ReceiptController::class, 'create']
    )->name('receipts.create');


    // Store Payment & Generate Receipt
    Route::post(
        '/invoices/{invoice}/receipt',
        [ReceiptController::class, 'store']
    )->name('receipts.store');


    // Receipt Details
    Route::get(
        '/receipts/{receipt}',
        [ReceiptController::class, 'show']
    )->name('receipts.show');


    // Download Receipt PDF
    Route::get(
        '/receipts/{receipt}/pdf',
        [ReceiptController::class, 'downloadPdf']
    )->name('receipts.pdf');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])
        ->name('reports.index');

    // Profile
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});

require __DIR__.'/auth.php';