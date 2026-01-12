<?php

use App\Http\Controllers\OrderReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/report/staff-productivity', [ReportController::class, 'staffProductivity'])
        ->name('report.staff-productivity');
    Route::get('/report/completed-orders', [OrderReportController::class, 'completedOrders'])
    ->name('report.completed-orders');
});


