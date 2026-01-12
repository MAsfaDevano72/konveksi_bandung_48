<div style="overflow-x: auto; border: 1px solid #e5e7eb; border-radius: 8px;">
    <table style="width: 100%; text-align: left; font-size: 12px; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #e5f0fa; border-bottom: 1px solid #d1d9e9;">
                <th style="padding: 8px 12px; font-size: 14px; font-weight: bold; color: #252d3b;">Waktu</th>
                <th style="padding: 8px 12px; font-size: 14px; font-weight: bold; color: #252d3b;">Tahap</th>
                <th style="padding: 8px 12px; font-size: 14px; font-weight: bold; color: #252d3b;">Status</th>
                <th style="padding: 8px 12px; font-size: 14px; font-weight: bold; color: #252d3b;">Petugas</th>
            </tr>
        </thead>
        <tbody style="background-color: white;">
            @forelse($getState() as $log)
                <tr style="border-bottom: 1px solid #f3f4f6;">
                    {{-- Format Waktu: 12 Des 2025, 11:05:01 --}}
                    <td style="padding: 8px 12px; font-weight: 600; white-space: nowrap; color: #2f343d;">
                        {{ \Carbon\Carbon::parse($log->timestamp)->translatedFormat('d M Y, H:i:s') }}
                    </td>

                    {{-- Badge Tahap dengan Inline Style --}}
                    <td style="padding: 8px 12px;">
                        @php
                            $stageColor = match($log->stage) {
                                'Waiting', 'Menunggu' => '#6b7280', 
                                'Cutting', 'Potongan' => '#ffbc48', 
                                'Sewing', 'Jahit'    => '#6ba4ff', 
                                'QC', 'Packing'      => '#a37dfc', 
                                'Selesai', 'Done'    => '#3debb1', 
                                default              => '#4b5563',
                            };

                            $stageName = match($log->stage) {
                                'Waiting' => 'Menunggu',
                                'Cutting' => 'Potong',
                                'Sewing'  => 'Jahit',
                                'QC'      => 'Packing',
                                'Done'    => 'Selesai',
                                default   => $log->stage,
                            };
                        @endphp
                        <span style="padding: 2px 8px; border-radius: 9999px; color: #eeeeee; font-size: 10px; font-weight: 600; text-transform: uppercase; background-color: {{ $stageColor }};">
                            {{ $stageName }}
                        </span>
                    </td>

                    {{-- Badge Status dengan Inline Style --}}
                    <td style="padding: 8px 12px;">
                        @php
                            $statusColor = match($log->status) {
                                'Selesai', 'Done', 'Mulai' => '#10b981', // Green
                                'Sedang Diproses'          => '#f97316', // Orange
                                'Menunggu', 'Waiting'      => '#9ca3af', // Gray
                                default                    => '#2563eb', // Blue
                            };
                        @endphp
                        <span style="padding: 2px 8px; border-radius: 4px; color: white; font-size: 10px; font-weight: 600; background-color: {{ $statusColor }};">
                            {{ $log->status }}
                        </span>
                    </td>

                    {{-- Petugas --}}
                    <td style="padding: 8px 12px; color: #2f3641; display: flex; align-items: center; gap: 4px;">
                        <svg style="width: 12px; height: 12px; font-weight: bold; font-size: 12px; color: #2f3641;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                        {{-- Ganti ke $log->employee->name jika relasinya adalah employee --}}
                        {{ $log->employee?->name ?? ($log->user?->name ?? 'System') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="padding: 12px; text-align: center; color: #9ca3af; font-style: italic;">
                        Belum ada riwayat aktivitas.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>