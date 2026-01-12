<?php
namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\ProductionOutput;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function staffProductivity(Request $request)
    {
        // 1. Tentukan rentang waktu (Default: Senin s/d Sabtu)
        $start = $request->start_date 
            ? Carbon::parse($request->start_date) 
            : now()->startOfWeek(Carbon::MONDAY);

        $end = $request->end_date 
            ? Carbon::parse($request->end_date) 
            : $start->copy()->addDays(5);

        $queryStart = $start->copy()->startOfDay();
        $queryEnd = $end->copy()->endOfDay();

        // 2. Ambil data perusahaan... (tetap sama)
        $setting = Setting::first();

        // 3. Ambil data produktivitas pegawai
        $reportData = DB::table('production_outputs')
            ->join('employees', 'production_outputs.employee_id', '=', 'employees.id')
            ->leftJoin('role_rates', 'employees.job_desk', '=', 'role_rates.role_name') 
            ->select(
                'employees.name as employee_name',
                'employees.job_desk as job_desk',
                'production_outputs.stage',
                DB::raw('SUM(production_outputs.qty) as total_qty'),
                DB::raw('SUM(
                    production_outputs.qty * IF(employees.rate_per_pcs > 0, employees.rate_per_pcs, COALESCE(role_rates.rate_per_pcs, 0))
                ) as total_wage')
            )
            ->whereBetween('production_outputs.created_at', [$queryStart, $queryEnd])
            ->groupBy(
                'employees.id', 
                'employees.name', 
                'employees.job_desk',
                'production_outputs.stage', 
                'employees.rate_per_pcs', 
                'role_rates.rate_per_pcs')
            ->get();

        // 4. Load View dan Generate PDF
        $pdf = Pdf::loadView('reports.staff-productivity', [
            'data' => $reportData,
            'setting' => $setting,
            'start' => $start->translatedFormat('d F Y'),
            'end' => $end->translatedFormat('d F Y'),
        ]);

        // 5. Tentukan nama file berdasarkan rentang tanggal
        $formattedStart = $start->format('d-m-Y');
        $formattedEnd = $end->format('d-m-Y');
        $filename = "Laporan_Produktivitas_Pegawai_{$formattedStart}_sd_{$formattedEnd}.pdf";

        return $pdf->stream($filename);
        return $pdf->download($filename);
    }
}