<x-filament-panels::page>
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <p style="font-size: 20px; font-weight: bold; font-style: italic;" class="text-primary-500">Presensi pegawai hari ini :</p>
        <div style="background: #262626; padding: 8px 15px; border-radius: 8px; border: 1px solid #444; color: #f59e0b; font-weight: bold;" >
            📅 {{ $todayDate }}
        </div>
    </div>

    <div style="background: #1f1f1f; border-radius: 12px; border: 1px solid #333; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; color: white;">
            <thead style="background: #262626; text-align: left;" >
                <tr>
                    <th style="padding: 15px; border-bottom: 1px solid #333; color: '#f59e0b';">Nama Pegawai</th>
                    <th style="padding: 15px; border-bottom: 1px solid #333;">Jabatan</th>
                    <th style="padding: 15px; border-bottom: 1px solid #333;">Status Hari Ini</th>
                    <th style="padding: 15px; border-bottom: 1px solid #333; text-align: center;">Keterangan</th>
                    <th style="padding: 15px; border-bottom: 1px solid #333; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                    @php
                        $attendance = \App\Models\Attendance::where('employee_id', $employee->id)
                                        ->where('date', $this->date)->first();
                    @endphp
                    <tr style="border-bottom: 1px solid #333;">
                        <td style="padding: 15px; font-weight: bold;">{{ $employee->name }}</td>
                        <td style="padding: 15px; color: #a3a3a3;">{{ $employee->job_desk ?? 'Pegawai' }}</td>
                        <td style="padding: 15px;">
                            @if($attendance)
                                @php
                                    $bg = $attendance->status == 'Hadir' ? '#10b981' : ($attendance->status == 'Lembur' ? '#f59e0b' : '#ef4444');
                                @endphp
                                <span style="padding: 4px 12px; background: {{ $bg }}; color: white; border-radius: 20px; font-size: 12px; font-weight: bold;">
                                    ✓ Checked: {{ $attendance->status }} {{ $attendance->overtime_hours > 0 ? "({$attendance->overtime_hours} Jam)" : "" }}
                                </span>
                            @else
                                <span style="color: #525252; font-style: italic; font-size: 13px;">Belum Absen</span>
                            @endif
                        </td>
                        <td style="padding: 15px; color: #a3a3a3; text-align: center;">{{ $attendance->note ?? '-' }}</td>
                        <td style="padding: 15px; text-align: right;">
                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                @if(!$attendance)
                                    <button 
                                        wire:click="markAsPresent({{ $employee->id }})" 
                                        {{ !$canClick ? 'disabled' : '' }}
                                        style="padding: 6px 12px; background: {{ $canClick ? '#10b981' : '#404040' }}; color: white; border: none; border-radius: 6px; cursor: {{ $canClick ? 'pointer' : 'not-allowed' }}; font-weight: 600;">
                                        Hadir
                                    </button>

                                    <button 
                                        wire:click="openIzinModal({{ $employee->id }})" 
                                        {{ !$canClick ? 'disabled' : '' }}
                                        style="padding: 6px 12px; background: {{ $canClick ? '#ef4444' : '#404040' }}; color: white; border: none; border-radius: 6px; cursor: {{ $canClick ? 'pointer' : 'not-allowed' }}; font-weight: 600;">
                                        Izin/Lainnya
                                    </button>
                                @endif

                                @if(!$attendance || $attendance->status == 'Hadir')
                                    <button 
                                        wire:click="openOvertimeModal({{ $employee->id }})" 
                                        {{ !$canClick ? 'disabled' : '' }}
                                        style="padding: 6px 12px; background: {{ $canClick ? '#f59e0b' : '#404040' }}; color: white; border: none; border-radius: 6px; cursor: {{ $canClick ? 'pointer' : 'not-allowed' }}; font-weight: 600;">
                                        Lembur
                                    </button>
                                @endif
                            </div>
                            @if(!$canClick)
                                <div style="font-size: 10px; color: #ef4444; margin-top: 4px;">Di luar jam operasional</div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- MODAL LEMBUR (DENGAN INPUT WAKTU) --}}
    <x-filament::modal id="overtime-modal" width="md">
        <x-slot name="heading">Input Jam Lembur</x-slot>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; padding: 15px 0;">
            <div>
                <label style="display: block; font-size: 12px; color: #a3a3a3; margin-bottom: 5px;">Mulai</label>
                <input type="time" wire:model="overtime_start" style="width: 100%; background: #262626; border: 1px solid #444; color: white; padding: 8px; border-radius: 6px;">
            </div>
            <div>
                <label style="display: block; font-size: 12px; color: #a3a3a3; margin-bottom: 5px;">Sampai</label>
                <input type="time" wire:model="overtime_end" style="width: 100%; background: #262626; border: 1px solid #444; color: white; padding: 8px; border-radius: 6px;">
            </div>
        </div>
        <x-slot name="footer">
            <x-filament::button wire:click="saveOvertime" color="warning" style="width: 100%;">Simpan Data Lembur</x-filament::button>
        </x-slot>
    </x-filament::modal>

    {{-- MODAL IZIN (DENGAN DROPDOWN LEBIH BAGUS) --}}
    <x-filament::modal id="izin-modal" width="md">
        <x-slot name="heading">Input Izin / Ketidakhadiran</x-slot>
        <div style="padding: 15px 0; display: flex; flex-direction: column; gap: 15px;">
            <div>
                <label style="display: block; font-size: 12px; color: #a3a3a3; margin-bottom: 5px;">Pilih Alasan</label>
                <select wire:model="izinStatus" style="width: 100%; background: #262626; border: 1px solid #444; color: white; padding: 8px; border-radius: 6px;">
                    <option value="Izin">Izin</option>
                    <option value="Sakit">Sakit</option>
                    <option value="Libur">Libur</option>
                    <option value="Alpa">Alpa</option>
                </select>
            </div>
            <div>
                <label style="display: block; font-size: 12px; color: #a3a3a3; margin-bottom: 5px;">Catatan Tambahan</label>
                <textarea wire:model="note" placeholder="Contoh: Sakit tipes" style="width: 100%; background: #262626; border: 1px solid #444; color: white; padding: 8px; border-radius: 6px; min-height: 80px;"></textarea>
            </div>
        </div>
        <x-slot name="footer">
            <x-filament::button wire:click="saveIzin" color="danger" style="width: 100%;">Simpan Status</x-filament::button>
        </x-slot>
    </x-filament::modal>
</x-filament-panels::page>