<!DOCTYPE html>
<html>
<head>
    <title>Laporan Produktivitas Mingguan</title>
    <style>
        @page { margin: 1cm; }
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            font-size: 11px; 
            color: #333;
            line-height: 1.4;
        }
        
        /* Kop Surat */
        .kop-table { width: 100%; border-bottom: 3px double #000; margin-bottom: 20px; }
        .kop-table td { border: none !important; padding-bottom: 10px; }
        .company-name { font-size: 26px; font-weight: bold; color: #1a1a1a; text-transform: uppercase; }
        .company-info { font-size: 14px; color: #555; }

        /* Judul Laporan */
        .report-title { text-align: center; margin-bottom: 20px; }
        .report-title h2 { margin: 0; font-size: 16px; text-transform: uppercase; border-bottom: 1px solid #333; display: inline-block; padding-bottom: 5px; }
        .report-title p { margin: 5px 0 0; font-size: 12px; color: #666; }

        /* Style Tabel Utama */
        .content-table { width: 100%; border-collapse: collapse; margin-top: 10px; table-layout: fixed; }
        .content-table th { 
            background-color: #2c3e50; 
            color: white; 
            text-align: left; 
            padding: 10px 8px;
            text-transform: uppercase;
            font-size: 10px;
        }
        .content-table td { 
            padding: 8px; 
            border-bottom: 1px solid #eee; 
            vertical-align: middle;
            word-wrap: break-word;
        }
        .content-table tr:nth-child(even) { background-color: #fcfcfc; }
        
        /* Utility */
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        
        /* Footer/Tanda Tangan */
        .footer-container { margin-top: 40px; width: 100%; }
        .signature-box { width: 200px; float: right; text-align: center; }
        .signature-space { height: 70px; }

        .total-row { background-color: #eee !important; font-weight: bold; font-size: 12px; }
    </style>
</head>
<body>
    {{-- KOP SURAT --}}
    <table class="kop-table">
        <tr>
            <td style="width: 18%; text-align: center;">
                <img src="{{ public_path('images/konveksi_bandung_48.png') }}" style="width: 90px;">
            </td>
            <td style="width: 70%; text-align: center; padding-right: 20px;">
                <div class="company-name">{{ $setting->company_name ?? 'KONVEKSI BANDUNG 48' }}</div>
                <div class="company-info">
                    {{ $setting->company_address ?? 'Alamat Belum Diatur' }}<br>
                    Email: {{ $setting->company_email ?? '-' }} | Telp: {{ $setting->company_phone ?? '-' }}
                </div>
            </td>
            <td style="width: 12%; text-align: center;">
            </td>
        </tr>
    </table>

    {{-- JUDUL --}}
    <div class="report-title">
        <h2>Laporan Kinerja & Estimasi Upah Pegawai</h2>
        <p>Periode: {{ $start }} - {{ $end }}</p>
    </div>

    <table class="content-table">
        <thead>
            <tr>
                <th style="width: 25%;">Nama Pegawai</th>
                <th style="width: 20%;">Job Desk</th>
                <th style="width: 15%;" class="text-center">Hari Kerja</th>
                <th style="width: 15%;" class="text-right">Total Hasil</th>
                <th style="width: 25%;" class="text-right">Estimasi Upah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td class="font-bold">{{ $item->employee_name }}</td>
                <td>{{ $item->job_desk }}</td>
                <td class="text-center">{{ $item->attendance_info }}</td>
                <td class="text-right">{{ number_format($item->total_qty, 0, ',', '.') }} Pcs</td>
                <td class="text-right font-bold">
                    Rp {{ number_format($item->total_wage, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" class="text-right">TOTAL PENGELUARAN UPAH</td>
                <td class="text-right">Rp {{ number_format($total_keseluruhan, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer-container">
        <div class="signature-box">
            <p>Bandung, {{ now()->translatedFormat('d F Y') }}</p>
            <p style="margin-top: -10px;">Pemilik Konveksi,</p>
            <div class="signature-space"></div>
            <p class="font-bold">( ____________________ )</p>
            <p style="font-size: 9px; color: #777;">{{ $setting->company_name ?? 'Konveksi Bandung 48' }}</p>
        </div>
        <div style="clear: both;"></div>
    </div>

    <div style="margin-top: 20px; font-size: 9px; color: #888;">
        * Laporan ini dihasilkan otomatis oleh sistem pada {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>