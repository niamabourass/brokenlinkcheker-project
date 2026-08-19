<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\UserScanController;


/*
| User Scanner
*/

Route::get('/', [UserScanController::class, 'index']);

Route::post('/start-scan', [UserScanController::class, 'startScan'])
    ->middleware('auth');

Route::post('/scan-step', [UserScanController::class, 'scanStep']);

Route::get('/result', [UserScanController::class, 'result'])
    ->middleware('auth')
    ->name('result');

Route::get('/export-csv', [UserScanController::class, 'exportCsv'])
    ->middleware('auth')
    ->name('export.csv');


Route::get('/history', [UserScanController::class, 'history'])
    ->middleware('auth')
    ->name('user.history');

Route::get('/history/{id}', [UserScanController::class, 'historyShow'])
    ->middleware('auth')
    ->name('user.history.show');


Route::post('/check-url-statut', [UserScanController::class,'checkUrl']);

Route::post('/send-report', [UserScanController::class, 'sendReport'])
    ->name('send.report');



/*
| Admin Authentication
*/

Route::get('/admin/login', [AdminAuthController::class, 'loginForm'])
    ->name('admin.login');

Route::post('/admin/login', [AdminAuthController::class, 'login'])
    ->name('admin.login.post');



/*
| Admin Dashboard
*/

Route::middleware('auth:admin')
    ->prefix('admin')
    ->group(function () {


        Route::get('/', [AdminController::class, 'index'])
            ->name('admin.dashboard');


        Route::post('/logout', [AdminAuthController::class, 'logout'])
            ->name('admin.logout');


        Route::get('/scans', [AdminController::class, 'scans'])
            ->name('admin.scans');


        Route::get('/scans/{id}', [AdminController::class,'show'])
            ->name('admin.show');


        Route::get('/broken-links', [AdminController::class, 'brokenLinks'])
            ->name('admin.broken-links');


        Route::get('/reports', [AdminController::class, 'reports'])
            ->name('admin.reports');


        Route::get('/settings', [AdminController::class, 'settings'])
            ->name('admin.settings');


        Route::post('/settings', [AdminController::class, 'updateSettings'])
            ->name('admin.settings.update');


        Route::get('/new-scan', [AdminController::class, 'newScan'])
            ->name('admin.new-scan');

        Route::post('/start-scan', [AdminController::class, 'startScan'])
            ->name('admin.start-scan');

        Route::post('/scan-step', [AdminController::class, 'scanStep'])
            ->name('admin.scan-step');

        Route::get('/result', [AdminController::class, 'result'])
            ->name('admin.result');


        Route::get('/export/csv', [AdminController::class, 'exportCsv'])
            ->name('admin.export.csv');


        Route::get('/export/pdf', [AdminController::class, 'exportPdf'])
            ->name('admin.export.pdf');


        Route::get('/website-history/{id}',
            [AdminController::class, 'websiteHistory'])
            ->name('admin.website.history');


    });



/*
| Breeze routes
*/

require __DIR__.'/auth.php';