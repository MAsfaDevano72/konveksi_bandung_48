<x-filament-panels::page>
    {{-- Indikator Periode Aktif --}}
    <div class="mb-2 text-sm text-gray-500 italic">
        Menampilkan data: <span class="font-bold text-primary-600">{{ $label_periode }}</span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        {{-- Card Hasil Kerja --}}
        <x-filament::section>
            <x-slot name="heading">Hasil Kerja</x-slot>
            <div class="text-3xl font-bold text-primary-600">
                {{ $total_minggu_ini }} <span class="text-sm font-normal text-gray-500">Pcs</span>
            </div>
            
            <p class="text-xs text-gray-400">
                @if($is_filtered)
                    Total produksi dalam periode terpilih
                @else
                    Terhitung dari hari Senin sampai Sabtu minggu ini
                @endif
            </p>
        </x-filament::section>

        {{-- Card Estimasi Pendapatan --}}
        <x-filament::section>
            <x-slot name="heading">Estimasi Pendapatan</x-slot>
            <div class="text-3xl font-bold text-success-600">
                Rp {{ number_format($estimasi_gaji, 0, ',', '.') }}
                
                {{-- Tambahkan teks hanya jika tidak sedang di-filter --}}
                @if(!$is_filtered)
                    <span class="text-sm text-gray-600 font-normal">/ Minggu ini</span>
                @endif
            </div>
            <p class="text-xs text-gray-400">Berdasarkan tarif per pcs yang berlaku, Rp {{ number_format($rate_per_pcs, 0, ',', '.') }} / Pcs</p>
        </x-filament::section>
    </div>

    {{-- Sisanya sama persis dengan tabel riwayat Anda sebelumnya --}}
    <x-filament::section class="mt-6">
        <x-slot name="heading">Riwayat Pekerjaan Terbaru</x-slot>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" style="min-width: 650px; width: 100%;">
                {{-- ... isi table Anda tetap sama ... --}}
                <thead>
                    <tr class="border-b dark:border-white/10">
                        <th class="text-sm font-bold px-2">No.</th>
                        <th class="py-3 text-sm font-bold px-4">Tanggal & Waktu</th>
                        <th class="text-sm font-bold px-4">No. SPK</th>
                        <th class="text-sm font-bold px-4">Bagian</th>
                        <th class="text-sm font-bold px-4">Job Desk</th>
                        <th class="text-sm font-bold px-4">Jumlah Pcs</th>
                        <th class="text-sm text-center font-bold px-4">Upah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-white/5">
                    @foreach($outputs as $output)
                    <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition">
                        <td class="py-3 text-sm font-medium px-4">{{ $loop->iteration }}.</td>
                        <td class="py-3 text-sm font-medium px-4 whitespace-nowrap">
                            {{ $output->created_at->translatedFormat('d F Y H:i') }} WIB
                        </td>
                        <td class="text-sm font-medium text-primary-600 px-4">{{ $output->order?->order_number ?? '-' }}</td>
                        <td class="text-sm px-4">
                            @if($output->stage == 'Sewing') Bagian Jahit
                            @elseif($output->stage == 'Cutting') Bagian Potong Kain
                            @elseif($output->stage == 'QC/Packing') Bagian QC/Packing
                            @else {{ $output->stage }}
                            @endif
                        </td>
                        <td class="text-sm font-medium px-4">{{ $job_desk }}</td>
                        <td class="font-bold text-sm px-4 text-center text-orange-600 whitespace-nowrap">{{ $output->qty }} Pcs</td>
                        <td class="text-sm font-medium px-4">Rp {{ number_format($rate_per_pcs * $output->qty, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-filament::section>
</x-filament-panels::page>