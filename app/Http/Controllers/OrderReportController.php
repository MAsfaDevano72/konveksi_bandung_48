<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class OrderReportController extends Controller
{
    public function completedOrders(Request $request)
    {
        $start = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : now()->startOfMonth();
        $end = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : now()->endOfDay();

        $orders = DB::table('orders')
            ->where('status', 'Done')
            ->whereBetween('created_at', [$start, $end])
            ->get();

        $totalOmzet = $orders->sum('total_price');

        $pdf = Pdf::loadView('reports.completed-orders', [
            'orders' => $orders,
            'start' => $start->translatedFormat('d F Y'),
            'end' => $end->translatedFormat('d F Y'),
            'totalOmzet' => $totalOmzet,
            'setting' => \App\Models\Setting::first(),
        ]);

        $filename = "Laporan_Produktivitas_Pegawai_{$start->format('d-m-Y')}_sd_{$end->format('d-m-Y')}.pdf";
        return $pdf->stream($filename);
        return $pdf->download($filename);
    }
}
