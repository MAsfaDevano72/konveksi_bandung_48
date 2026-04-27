<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PrintSpkController extends Controller
{
    public function print(Order $order)
    {
        $sewingLog = $order->productionLogs()
            ->where('stage', 'Sewing')
            ->whereNotNull('employee_id')
            ->latest()
            ->first();

        $dataLog = $order->productionLogs()
            ->where('notes', 'like', '%SIZES_DATA:%')
            ->latest()
            ->first();

        $sizesData = $dataLog ? $this->parseSizes($dataLog->notes) : [];

        $data = [
            'order' => $order,
            'petugas' => $sewingLog?->employee?->name ?? 'Belum Ada',
            'date' => now()->format('d F Y'),
            'sizes' => is_array($sizesData) ? $sizesData : [], 
        ];

        $pdf = Pdf::loadView('print.spk-sewing', $data);
        return $pdf->setPaper('a6', 'portrait')->stream("SPK-Sewing-{$order->order_number}.pdf");
    }

    private function parseSizes($notes)
    {
        if (!$notes) return [];

        // Regex diperkuat untuk menangkap JSON di antara kurung siku
        if (preg_match('/SIZES_DATA:(\[.*?\])/', $notes, $matches)) {
            $result = json_decode($matches[1], true);
            return is_array($result) ? $result : [];
        }
        
        return [];
    }
}