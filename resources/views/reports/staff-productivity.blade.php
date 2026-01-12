<!DOCTYPE html>
<html>
<head>
    <title>Laporan Produktivitas Mingguan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .company-name { font-size: 18px; font-weight: bold; text-transform: uppercase; margin-bottom: 5px; }
        
        /* Table Style Utama */
        table.content-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.content-table th, table.content-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        table.content-table th { background-color: #f2f2f2; }
        
        .text-right { text-align: right; }
        .footer { margin-top: 30px; text-align: right; }
        
        /* Helper untuk Kop Surat */
        .kop-table { width: 100%; border-bottom: 2px solid #000; margin-bottom: 20px; }
        .kop-table td { border: none !important; padding-bottom: 10px; }
    </style>
</head>
<body>
    {{-- KOP SURAT DENGAN LOGO --}}
   <table class="kop-table">
        <tr>
            {{-- KOLOM 1: LOGO (20%) --}}
            <td style="width: 20%; text-align: center; vertical-align: middle;">
                <img src="{{ public_path('images/konveksi_bandung_48.png') }}" style="width: 80px; height: auto;">
            </td>

            {{-- KOLOM 2: TEKS INFORMASI (60%) --}}
            <td style="width: 60%; text-align: center; vertical-align: middle;">
                <div class="company-name">{{ $setting->company_name ?? 'KONVEKSI BANDUNG 48' }}</div>
                <div style="margin-bottom: 2px;">{{ $setting->company_address ?? 'Alamat Belum Diatur' }}</div>
                <div>Email: {{ $setting->company_email ?? '-' }} | Telp: {{ $setting->company_phone ?? '-' }}</div>
            </td>

            {{-- KOLOM 3: PENYEIMBANG KOSONG (20%) --}}
            <td style="width: 20%;"></td>
        </tr>
    </table>

    <h3 style="text-align: center;">LAPORAN PRODUKTIVITAS PEGAWAI</h3>
    <p style="text-align: center;">Periode: {{ $start }} - {{ $end }}</p>

    <table class="content-table">
        <thead>
            <tr>
                <th>Nama Pegawai</th>
                <th>Job Desk</th>
                <th>Bagian (Stage)</th>
                <th class="text-right">Total Hasil</th>
                <th class="text-right">Total Upah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            @php
                $stageAlias = $item->stage;
                if($item->stage == 'Sewing') $stageAlias = 'Bagian Jahit';
                if($item->stage == 'Cutting') $stageAlias = 'Bagian Potong Kain';
            @endphp
            <tr>
                <td>{{ $item->employee_name }}</td>
                <td>{{ $item->job_desk }}</td>
                <td>{{ $stageAlias }}</td>
                <td class="text-right">{{ $item->total_qty }} Pcs</td>
                <td class="text-right">Rp {{ number_format($item->total_wage, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color: #f9f9f9; font-weight: bold;">
                <td colspan="4" class="text-right">TOTAL KESELURUHAN</td>
                <td class="text-right">Rp {{ number_format($data->sum('total_wage'), 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Bandung, {{ now()->translatedFormat('d F Y') }}</p>
        <br><br><br>
        <p>( ____________________ )</p>
        <p>Owner {{ $setting->company_name ?? 'KONVEKSI BANDUNG 48' }}</p>
    </div>
</body>
</html>