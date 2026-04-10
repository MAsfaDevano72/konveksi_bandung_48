<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Employee;
use App\Models\ProductionLog;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function staffProductivity(Request $request)
    {
        // 1. Tentukan rentang waktu
        $start = $request->start_date 
            ? Carbon::parse($request->start_date)->startOfDay() 
            : now()->startOfWeek(Carbon::SUNDAY)->startOfDay();

        $end = $request->end_date 
            ? Carbon::parse($request->end_date)->endOfDay() 
            : now()->endOfWeek(Carbon::SATURDAY)->endOfDay();

        // 2. Ambil data perusahaan
        $setting = Setting::first();

        // 3. Ambil data pegawai (Kecuali Admin & Owner)
        $employees = Employee::with(['roleRate'])
            ->whereNotIn('job_desk', ['Owner', 'Admin'])
            ->get();

        // 4. Transform data agar sesuai dengan logika Dashboard
        $reportData = $employees->map(function ($emp) use ($start, $end) {
            $salaryType = $emp->roleRate->rate_type ?? 'pcs';
            $standardRate = $emp->roleRate->rate_amount ?? 0;
            
            // Hitung Total Qty
            $outputs = $emp->outputs()
                ->with(['order.garmentModel'])
                ->whereBetween('created_at', [$start, $end])
                ->get();
            
            $totalQty = $outputs->sum('qty');
            $totalWage = 0;

            if ($salaryType === 'daily') {
                // Logika Harian 
                $days = ProductionLog::where('employee_id', $emp->id)
                    ->whereBetween('timestamp', [$start, $end])
                    ->count(DB::raw('DISTINCT DATE(timestamp)'));
                
                $totalWage = $days * $standardRate;
                $attendanceInfo = $days . " Hari";
            } else {
                // Logika Borongan (Pcs)
                foreach ($outputs as $out) {
                    $modelRate = $out->order->garmentModel->tailor_rate ?? $standardRate;
                    $totalWage += ($out->qty * $modelRate);
                }
                $attendanceInfo = "-";
            }

            return (object) [
                'employee_name' => $emp->name,
                'job_desk' => $emp->job_desk,
                'attendance_info' => $attendanceInfo,
                'total_qty' => $totalQty,
                'total_wage' => $totalWage,
            ];
        });

        // 5. Load View dan Generate PDF
        $pdf = Pdf::loadView('reports.staff-productivity', [
            'data' => $reportData,
            'setting' => $setting,
            'start' => $start->translatedFormat('d F Y'),
            'end' => $end->translatedFormat('d F Y'),
            'total_keseluruhan' => $reportData->sum('total_wage')
        ]);

        $filename = "Laporan_Produktivitas_Pegawai_{$start->format('d-m-Y')}_sd_{$end->format('d-m-Y')}.pdf";

        return $pdf->stream($filename);
    }
}