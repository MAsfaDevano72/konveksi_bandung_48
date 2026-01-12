<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pesanan Selesai</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .company-name { font-size: 18px; font-weight: bold; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .summary { margin-top: 20px; font-size: 14px; font-weight: bold; text-align: right; }
        .footer { margin-top: 30px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">{{ $setting->company_name ?? 'KONVEKSI BANDUNG 48' }}</div>
        <div>{{ $setting->company_address ?? 'Alamat Belum Diatur' }}</div>
        <div>Email: {{ $setting->company_email ?? '-' }} | Telp: {{ $setting->company_phone ?? '-' }}</div>
    </div>

    <h3 style="text-align: center;">LAPORAN REKAP PESANAN SELESAI</h3>
    <p style="text-align: center;">Periode: {{ $start }} - {{ $end }}</p>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>No. SPK</th>
                <th>Instansi</th>
                <th>Pelanggan</th>
                <th>Produk</th>
                <th>Qty</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->agency_name }}</td>
                <td>{{ $order->client_name }}</td>
                <td>{{ $order->product_name }}</td>
                <td>{{ $order->quantity }} Pcs</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Bandung, {{ now()->translatedFormat('d F Y') }}</p>
        <br><br><br>
        <p>( ____________________ )</p>
        <p>Owner {{ $setting->company_name ?? 'KONVEKSI BANDUNG 48' }}</p>
    </div>
</body>
</html>