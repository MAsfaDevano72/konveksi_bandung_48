<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pendapatan ({{ strtoupper($tipe) }})</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #999; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .total { font-weight: bold; background-color: #eee; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <h2 style="text-align: center; margin-bottom: 5px;">Konveksi Bandung 48</h2>
    <h3 style="text-align: center; margin-top: 0;">Laporan Pendapatan {{ strtoupper($tipe) }}</h3>
    <p><strong>Periode:</strong> <em>{{ $periode }}</em></p>

    <table>
        <thead>
            <tr>
                <th width="30px" class="text-center">No.</th>
                @if($tipe === 'harian')
                    <th>Tanggal</th>
                    <th>No. SPK</th>
                    <th>Instansi</th>
                    <th>Produk</th>
                    <th class="text-center">Qty</th>
                @else
                    <th>Periode {{ ucfirst($tipe) }}</th>
                    <th class="text-center">Jumlah SPK</th>
                    <th class="text-center">Total Qty</th>
                @endif
                <th class="text-right">Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $order)
            <tr>
                <td class="text-center">{{ $loop->iteration }}.</td>
                @if($tipe === 'harian')
                    <td>{{ $order->created_at->translatedFormat('d F Y') }}</td>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->agency_name }}</td>
                    <td>{{ $order->product_name }}</td>
                    <td class="text-center">{{ $order->quantity }}</td>
                    <td class="text-right">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                @else
                    <td>
                        @if($tipe === 'bulanan') {{ \Illuminate\Support\Carbon::parse($order->created_at)->translatedFormat('F Y') }}
                        @elseif($tipe === 'mingguan') Minggu ke-{{ \Illuminate\Support\Carbon::parse($order->created_at)->weekOfYear }} ({{ \Illuminate\Support\Carbon::parse($order->created_at)->format('Y') }})
                        @else {{ \Illuminate\Support\Carbon::parse($order->created_at)->format('Y') }}
                        @endif
                    </td>
                    <td class="text-center">{{ $order->total_spk }} Pesanan</td>
                    <td class="text-center">{{ $order->total_qty }} Pcs</td>
                    <td class="text-right">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                @endif
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total">
                <td colspan="{{ $tipe === 'harian' ? 5 : 3 }}" style="text-align: left;">TOTAL KESELURUHAN:</td>
                <td class="text-center">{{ $records->sum($tipe === 'harian' ? 'quantity' : 'total_qty') }} Pcs</td>
                <td class="text-right">Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>