<x-filament-panels::page>
    <div class="mb-2 text-sm text-gray-500 italic">
        Menampilkan data: <span class="font-bold text-primary-600">{{ $label_periode }}</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- Card Hasil Kerja --}}
        <x-filament::section>
            <x-slot name="heading">
                {{ $salary_type === 'daily' ? 'Kehadiran Kerja' : 'Total Produksi' }}
            </x-slot>
            <div class="text-3xl font-bold text-primary-600">
                {{ $work_summary }} <span class="text-sm font-normal text-gray-500">{{ $salary_type === 'daily' ? 'Hari' : 'Pcs' }}</span>
            </div>
            <p class="text-xs text-gray-400 mt-1">
                {{ $is_filtered ? 'Data berdasarkan filter tanggal' : 'Terhitung Minggu ini' }}
            </p>
        </x-filament::section>

        {{-- Card Estimasi Pendapatan --}}
        <x-filament::section>
            <x-slot name="heading">Estimasi Pendapatan</x-slot>
            <div class="text-3xl font-bold text-success-600">
                Rp {{ number_format($total_income, 0, ',', '.') }}
            </div>
            <p class="text-xs text-gray-400 mt-1">
                @if($salary_type === 'daily')
                    Tarif: Rp {{ number_format($standard_rate, 0, ',', '.') }} / Hari
                @else
                    Berdasarkan tarif per model baju
                @endif
            </p>
        </x-filament::section>
    </div>

    <x-filament::section class="mt-6">
        <x-slot name="heading">Riwayat Pekerjaan</x-slot>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b dark:border-white/10 text-sm font-bold bg-gray-50 dark:bg-white/5">
                        <th class="py-3 px-4">No.</th>
                        <th class="px-4">Tanggal</th>
                        @if($salary_type === 'pcs')
                            <th class="px-4">No. SPK</th>
                            <th class="px-4">Model Baju</th>
                            <th class="px-4 text-center">Output</th>
                            <th class="px-4 text-right">Upah</th>
                        @else
                            <th class="px-4">Total Pekerjaan</th>
                            <th class="px-4 text-center">Status</th>
                            <th class="px-4 text-right">Upah Harian</th>
                            <th class="px-4 text-right">Aksi</th> @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-white/5">
                    @if($salary_type === 'pcs')
                        {{-- TAMPILAN PENJAHIT --}}
                        @forelse($outputs as $output)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition text-sm">
                            <td class="py-3 px-4">{{ $loop->iteration }}.</td>
                            <td class="px-4 whitespace-nowrap">{{ $output->created_at->translatedFormat('l, d F Y H:i') }}</td>
                            <td class="px-4 font-bold text-primary-600">{{ $output->order?->order_number ?? '-' }}</td>
                            <td class="px-4 text-gray-100 font-semibold">{{ $output->order?->garmentModel?->name ?? '-' }}</td>
                            <td class="px-4 text-center font-bold">{{ number_format($output->qty) }} Pcs</td>
                            <td class="px-4 text-right font-semibold" style="color: #119c40">
                                Rp {{ number_format($output->qty * ($output->order?->garmentModel?->tailor_rate ?? $standard_rate), 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                            <tr><td colspan="6" class="py-10 text-center text-gray-400 italic">Belum ada data produksi.</td></tr>
                        @endforelse
                    @else
                        {{-- TAMPILAN PEKERJAAN HARIAN --}}
                        @forelse($daily_grouped as $date => $group)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition text-sm">
                            <td class="py-3 px-4">{{ $loop->iteration }}.</td>
                            <td class="px-4 font-medium">{{ \Illuminate\Support\Carbon::parse($date)->translatedFormat('l, d F Y') }}</td>
                            <td class="px-4 font-semibold" style="color: #ebcb19;">{{ $group->count() }} Kali Input (SPK)</td>
                            <td class="px-4 text-center">
                                <span class="px-2 py-1 text-xs font-bold rounded-full" style="background-color: #d1fae5; color: #119c40;">Hadir & Selesai</span>
                            </td>
                            <td class="px-4 text-right font-bold text-success-600">
                                Rp {{ number_format($standard_rate, 0, ',', '.') }}
                            </td>
                            <td class="px-4 text-right">
                                {{-- MODAL DETAIL --}}
                                <x-filament::modal width="2xl">
                                    <x-slot name="trigger">
                                        <x-filament::button color="info" icon="heroicon-m-eye" size="sm" outlined>
                                            Detail
                                        </x-filament::button>
                                    </x-slot>

                                    <x-slot name="heading">
                                        Detail Pekerjaan: {{ \Illuminate\Support\Carbon::parse($date)->translatedFormat('d F Y') }}
                                    </x-slot>

                                    {{-- Isi Modal (Summary Cards) --}}
                                    <div class="space-y-4">
                                        @foreach($group as $item)
                                        <div style="background-color: #1f1f1f; border: 1px solid #333; border-radius: 12px; margin-bottom: 16px; overflow: hidden; font-family: ui-sans-serif, system-ui, sans-serif;">
                                            
                                            {{-- Header: No SPK & Waktu --}}
                                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px 15px; background-color: #262626; border-bottom: 1px solid #333;">
                                                <div style="display: flex; align-items: center; gap: 8px;">
                                                    <div style="width: 8px; height: 8px; background-color: #eab308; border-radius: 50%;"></div>
                                                    <span style="font-weight: 700; font-size: 13px; color: #fbbf24; letter-spacing: 0.5px;">{{ $item->order?->order_number ?? 'Bukan SPK' }}</span>
                                                </div>
                                                <span style="font-size: 11px; color: #a3a3a3;">{{ $item->created_at->format('H:i') }} WIB</span>
                                            </div>

                                            {{-- Body Utama --}}
                                            <div style="padding: 15px;">
                                                <table style="width: 100%; border-collapse: collapse;">
                                                    <tr>
                                                        {{-- Baris 1: Model & Tahap --}}
                                                        <td style="width: 50%; padding-bottom: 12px; vertical-align: top; text-align: left;">
                                                            <div style="font-size: 10px; color: #737373; text-transform: uppercase; font-weight: 700; margin-bottom: 4px;">Model Baju</div>
                                                            <div style="font-size: 14px; color: #e5e5e5; font-weight: 600;">{{ $item->order?->garmentModel?->name ?? ($item->order?->product_name ?? 'Model Tidak Diisi') }}</div>
                                                        </td>
                                                        <td style="width: 50%; padding-bottom: 12px; vertical-align: top; text-align: left;">
                                                            <div style="font-size: 10px; color: #737373; text-transform: uppercase; font-weight: 700; margin-bottom: 4px;">Tahap Kerja</div>
                                                            <div style="font-size: 14px; color: #e5e5e5; font-weight: 600;">{{ $item->stage ?? '-' }}</div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        {{-- Baris 2: Output & Warna --}}
                                                        <td style="width: 50%; vertical-align: top; text-align: left;">
                                                            <div style="font-size: 10px; color: #737373; text-transform: uppercase; font-weight: 700; margin-bottom: 4px;">Output / Ukuran</div>
                                                            <div style="font-size: 14px; color: #eab308; font-weight: 800;">
                                                                {{ $item->qty ?? 0 }} <span style="font-weight: 400; font-size: 12px; color: #737373;">Pcs</span>
                                                                <span style="margin: 0 5px; color: #404040;">|</span>
                                                                <span style="color: #e5e5e5;">{{ $item->size_detail }}</span>
                                                            </div>
                                                        </td>
                                                        <td style="width: 50%; vertical-align: top; text-align: left;">
                                                            <div style="font-size: 10px; color: #737373; text-transform: uppercase; font-weight: 700; margin-bottom: 4px;">Warna</div>
                                                            <div style="font-size: 14px; color: #e5e5e5; font-weight: 600;">{{ $item->order?->inventory?->color ?? ($item->order?->color ?? 'Default/Polos') }}</div>
                                                        </td>
                                                    </tr>
                                                </table>

                                                {{-- Section: Bahan Baku & Stok (Footer Card) --}}
                                                <div style="margin-top: 15px; padding-top: 12px; border-top: 1px dashed #404040; display: flex; justify-content: space-between; align-items: flex-end;">
                                                    <div style="flex: 1; text-align: left;">
                                                        <div style="font-size: 10px; color: #737373; text-transform: uppercase; font-weight: 700; margin-bottom: 4px;">Bahan Baku</div>
                                                        <div style="font-size: 13px; color: #d4d4d4; font-weight: 500;">{{ $item->order?->inventory?->name ??  'Kain Kosong' }}</div>
                                                    </div>
                                                    
                                                    <div style="display: flex; gap: 15px; text-align: right;">
                                                        <div>
                                                            <div style="font-size: 10px; color: #737373; text-transform: uppercase; font-weight: 700; margin-bottom: 2px;">Roll</div>
                                                            <div style="font-size: 13px; color: #e5e5e5; font-weight: 700;text-align: left;">{{ $item->order?->qty_roll ?? 0 }}</div>
                                                        </div>
                                                        <div style="border-left: 1px solid #404040; padding-left: 15px;">
                                                            <div style="font-size: 10px; color: #737373; text-transform: uppercase; font-weight: 700; margin-bottom: 2px;">Panjang</div>
                                                            <div style="font-size: 13px; color: #22c55e; font-weight: 700;">{{ number_format($item->order?->used_yard ?? 0, 2) }} <span style="font-size: 10px; font-weight: 400; color: #737373;">Yd</span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </x-filament::modal>
                            </td>
                        </tr>
                        @empty
                            <tr><td colspan="6" class="py-10 text-center text-gray-400 italic">Belum ada riwayat kehadiran.</td></tr>
                        @endforelse
                    @endif
                </tbody>
            </table>
        </div>
    </x-filament::section>
</x-filament-panels::page>