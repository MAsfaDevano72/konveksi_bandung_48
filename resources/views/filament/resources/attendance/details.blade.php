<div style="width: 100%; overflow-x: auto; border: 1px solid #272a31; border-radius: 8px; background-color: #181c22;">
    <table style="width: 100%; text-align: left; border-collapse: collapse; font-size: 0.875rem; color: #d1d5db;">
        <thead>
            <tr style="background-color: #292b30; color: #dfe1e6; text-transform: uppercase; font-size: 0.75rem;">
                <th style="padding: 12px 16px; border-bottom: 1px solid #374151;">Tanggal Absen</th>
                <th style="padding: 12px 16px; border-bottom: 1px solid #374151;">Status</th>
                <th style="padding: 12px 16px; border-bottom: 1px solid #374151; text-align: center;">Lembur</th>
                <th style="padding: 12px 16px; border-bottom: 1px solid #374151;">Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($getState() as $attendance)
                @php
                    // POIN 1: Nama Hari Lokal Indonesia
                    $tanggalLokal = \Carbon\Carbon::parse($attendance->date)->locale('id')->translatedFormat('l, d F Y');
                    
                    // POIN 2: Logika Warna Badge
                    $status = $attendance->status;
                    $badgeStyle = "padding: 4px 10px; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;";
                    
                    if (in_array($status, ['Hadir', 'Lembur'])) {
                        $badgeStyle .= "color: #065f46; background-color: #34d399;"; // Hijau
                    } elseif (in_array($status, ['Izin', 'Sakit'])) {
                        $badgeStyle .= "color: #92400e; background-color: #fbbf24;"; // Kuning/Amber
                    } elseif ($status == 'Alpa') {
                        $badgeStyle .= "color: #7f1d1d; background-color: #f87171;"; // Merah
                    } elseif ($status == 'Libur') {
                        $badgeStyle .= "color: #581c87; background-color: #c084fc;"; // Ungu
                    } else {
                        $badgeStyle .= "color: #374151; background-color: #9ca3af;"; // Default Abu
                    }
                @endphp
                <tr style="border-bottom: 1px solid #3e3f42; background-color: #3c3f42;">
                    <td style="padding: 12px 16px; color: #fbbf24; font-weight: bold;">
                        {{ $tanggalLokal }}
                    </td>
                    <td style="padding: 12px 16px;">
                        <span style="{{ $badgeStyle }}">
                            {{ $status }}
                        </span>
                    </td>
                    <td style="padding: 14px 18px; text-align: center;">
                        {{ $attendance->overtime_hours ?? 0 }} Jam
                    </td>
                    <td style="padding: 12px 16px; font-style: italic; color: #9ca3af;">
                        {{ $attendance->note ?? '-' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="padding: 24px; text-align: center; color: #f87171;">
                        Tidak ada data kehadiran untuk periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>