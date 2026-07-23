<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ProfileController;


Route::get('/', [ScanController::class, 'index']);


Route::post('/start-scan', [ScanController::class, 'startScan']);
Route::post('/scan-step', [ScanController::class, 'scanStep']);

Route::get('/result', [ScanController::class, 'result']);

Route::get('/export-csv', [ScanController::class, 'exportCsv']);

Route::post('/check-url-statut', [ScanController::class,'checkUrl']);

Route::post('/send-report', [ScanController::class, 'sendReport'])
    ->name('send.report');







/*
|--------------------------------------------------------------------------
| Admin Dashboard
|--------------------------------------------------------------------------
*/

Route::middleware('auth:admin')->group(function () {

    Route::get('/admin', [AdminController::class, 'index'])
        ->name('admin.dashboard');


    Route::get('/admin/scan/{id}', [AdminController::class, 'show'])
        ->name('admin.scan.details');


    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])
        ->name('admin.logout');

});


Route::get('/admin/scans/{id}', [AdminController::class,'show'])
    ->name('admin.show');


Route::get('/admin/scans', [AdminController::class, 'scans'])
    ->name('admin.scans');


Route::get('/admin/broken-links', [AdminController::class, 'brokenLinks'])
    ->name('admin.broken-links');


Route::get('/admin/reports', [AdminController::class, 'reports'])
    ->name('admin.reports');


Route::get('/admin/settings', [AdminController::class, 'settings'])
    ->name('admin.settings');

Route::post('/admin/settings', [AdminController::class, 'updateSettings'])
    ->name('admin.settings.update');


Route::get('/admin/new-scan', [AdminController::class, 'newScan'])
    ->name('admin.new-scan');



Route::get('/admin/export/csv', [AdminController::class, 'exportCsv'])
    ->name('admin.export.csv');

Route::get('/admin/export/pdf', [AdminController::class, 'exportPdf'])
    ->name('admin.export.pdf');



/*
|--------------------------------------------------------------------------
| Breeze routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';