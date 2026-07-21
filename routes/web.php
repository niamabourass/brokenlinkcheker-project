<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;

Route::get('/', [ScanController::class, 'index']);
Route::post('/start-scan', [ScanController::class, 'startScan']);
Route::post('/scan-step', [ScanController::class, 'scanStep']);
Route::get('/result', [ScanController::class, 'result']);
Route::get('/export-csv', [ScanController::class, 'exportCsv']);
Route::post('/check-url-statut',[ScanController::class,'checkUrl']);
Route::get('/admin/login', [AdminAuthController::class, 'loginForm'])
    ->name('login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);

Route::middleware('auth:admin')->group(function () {

    Route::get('/admin', [AdminController::class, 'index']);

    Route::get('/admin/scan/{id}', [AdminController::class, 'show'])
        ->name('admin.scan.details');

    Route::post('/admin/logout', [AdminAuthController::class, 'logout']);
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

Route::get('/admin/new-scan', [AdminController::class, 'newScan'])
    ->name('admin.new-scan');