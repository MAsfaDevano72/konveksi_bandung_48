<?php

use App\Filament\Resources\IncomeReportResource\Pages\ManageIncomeReports;
use App\Http\Controllers\OrderReportController;
use App\Http\Controllers\PrintSpkController;
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
    Route::get('/print-spk-sewing/{order}', [PrintSpkController::class, 'print'])
        ->name('print.spk.sewing')
        ->middleware(['auth']);
    Route::get('/cetak-pendapatan', [ManageIncomeReports::class, 'print'])
        ->name('print.income-report')
        ->middleware(['auth']);
});


