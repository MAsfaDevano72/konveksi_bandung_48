<!DOCTYPE html>
<html>
<head>
    <title>Surat Jalan Jahit - {{ $order->order_number }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; line-height: 1.5; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 20px; }
        .title { text-align: center; margin-bottom: 10px; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .main-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .main-table th, .main-table td { border: 1px solid #000; padding: 8px; text-align: left; }
        .main-table th { background-color: #f2f2f2; }
        .footer { margin-top: 50px; width: 100%; }
        .signature-box { float: right; text-align: center; width: 200px; }
        .clear { clear: both; }
    </style>
</head>
<body>
    <div class="header">
        <h1>KONVEKSI BANDUNG 48</h1>
        <p>Jl. Situgunting Timur II No. 48, 008/008, Suka Asih, Bojongloa Kaler, Kota Bandung   Telp: 0812-xxxx-xxxx</p>
    </div>

    <div class="title">
        <h2>Surat Jalan Penjahit</h2>
    </div>

    <table class="info-table">
        <tr>
            <td width="15%"><strong>No. SPK</strong></td><td>: <strong>{{ $order->order_number }}</strong></td>
            <td width="15%"><strong>Tanggal</strong></td><td>: <strong>{{ $date }}</strong></td>
        </tr>
        <tr>
            <td><strong>Penjahit</strong></td><td>: {{ $petugas }}</td>
            <td><strong>Instansi</strong></td><td>: {{ $order->agency_name }}</td>
        </tr>
    </table>

    <h3>Detail Produksi & Bahan</h3>
    <table class="main-table">
        <thead>
            <tr>
                <th>Model Baju</th>
                <th>Bahan / Kain</th>
                <th>Warna</th>
                <th>Pemakaian Bahan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $order->garmentModel?->name ?? '-' }}</td>
                <td>{{ $order->inventory?->name ?? '-' }}</td>
                <td>{{ $order->inventory?->color ?? '-' }}</td>
                <td>{{ $order->qty_roll ?? 1 }} Rol ({{ $order->used_yard ?? '-' }} Yard)</td>
            </tr>
        </tbody>
    </table>

    <h3>Total Jahit</h3>
    <table class="main-table">
        <thead>
            <tr>
                @if(count($sizes) > 0)
                    @foreach($sizes as $s) 
                        <th>Size</th> 
                    @endforeach
                @else
                    <th>Ukuran</th>
                @endif
                <th>Total Keseluruhan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @php $totalDihitung = 0; @endphp
                
                @if(count($sizes) > 0)
                    @foreach($sizes as $s) 
                        @php 
                            $qtyPerSize = $s['qty'] ?? 0; 
                            $totalDihitung += $qtyPerSize;
                        @endphp
                        <td><strong>{{ $s['size'] ?? '-' }}:</strong> {{ $qtyPerSize }} Pcs</td>
                    @endforeach
                @else
                    <td>Data ukuran belum diinput</td>
                @endif

                <td><strong>{{ $totalDihitung }} Pcs</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <div class="signature-box">
            <p>Hormat Kami,</p>
            <br><br><br>
            <p><strong>(............................................)</strong></p>
        </div>
    </div>
</body>
</html>