@php
    // 1. Logika Identifikasi ID Asli vs ID Bayangan
    $recordIdString = (string) $record->id;
    $isShadow = str_contains($recordIdString, 'qcshadow');
    $realId = str_replace('qcshadow-', '', $recordIdString);
    
    // Ambil data user & status dasar
    $user = auth()->user();
    $statusColors = match ($record->status) {
        'Waiting'    => ['bg' => '#F3F4F6', 'text' => '#374151', 'label' => 'Menunggu'], 
        'Cutting'    => ['bg' => '#FEF9C3', 'text' => '#f59e0b', 'label' => 'Potong'], 
        'Sewing'     => ['bg' => '#E0F2FE', 'text' => '#0EA5E9', 'label' => 'Jahit'], 
        'QC/Packing' => ['bg' => '#F3E8FF', 'text' => '#6B21A8', 'label' => 'QC/Packing'], 
        'Done'       => ['bg' => '#DCFCE7', 'text' => '#22C55E', 'label' => 'Selesai'], 
        default      => ['bg' => '#F3F4F6', 'text' => '#374151', 'label' => $record->status],
    };

    $actionLabel = match ($record->status) {
        'Cutting'    => 'Dipotong',
        'Sewing'     => 'Dijahit',
        'QC/Packing' => 'QC & Packing',
        default      => $record->status,
    };

    $isDone = in_array($record->status, ['Done', 'Selesai']);

    $canAction = false;
    if($user->hasAnyRole(['Owner', 'Admin'])) {
        $canAction = true;
    } elseif ($record->status === 'Cutting' && $user->hasRole('Cutting')) {
        $canAction = true;
    } elseif ($record->status === 'Sewing' && $user->hasRole('Tailor')) {
        $canAction = true;
    } elseif ($record->status === 'QC/Packing' && $user->hasRole('QC/Packing')) {
        $canAction = true;
    }
@endphp

<div
    id="{{ $record->id }}"
    wire:key="order-record-{{ $record->id }}"
    class="p-4 bg-white rounded-2xl shadow-sm border {{ $isShadow ? 'border-indigo-200 border-dashed' : 'border-gray-100' }} mb-3 group transition-all hover:ring-2 hover:ring-primary-500 cursor-grab active:cursor-grabbing relative overflow-hidden"
    style="border-radius: 8px;">
    
    {{-- Penanda Visual Card Bayangan (Hanya muncul jika itu cicilan ke QC) --}}
    @if($isShadow)
        <div class="absolute top-0 right-0">
            <div class="bg-indigo-500 text-white text-[7px] font-black px-2 py-0.5 rounded-bl-lg uppercase tracking-widest shadow-sm">
                Setoran Cicilan
            </div>
        </div>
    @endif

    {{-- Top: Badge SPK & Deadline --}}
    <div class="flex justify-between items-start mb-3">
        <div wire:click="mountAction('viewOrderDetails', {recordId: {{ $realId }}})" 
         class="cursor-pointer hover:underline flex">
            <span
                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider border border-black/5 gap-1"
                style="background-color: {{ $statusColors['bg'] }}; color: {{ $statusColors['text'] }};">
                {{ $record->order_number }}
                <x-heroicon-o-information-circle class="w-4 h-4" />
            </span>
        </div>
        <div class="text-right">
            <p class="text-[9px] text-gray-500 font-bold uppercase tracking-tighter leading-none">Deadline</p>
            <p class="text-[9px] font-extrabold text-gray-700">
                {{ \Carbon\Carbon::parse($record->deadline)->format('d M Y') }}
            </p>
        </div>
    </div>

    {{-- Info Utama --}}
    <div class="mb-4 cursor-pointer"
        wire:click="mountAction('viewOrderDetails', {recordId: {{ $realId }}})">
        <div class="text-[10px] font-bold text-gray-800 dark:text-gray-800 uppercase tracking-tight mb-0.5">
            {{ $record->agency_name }}
        </div>
        <h4 class="text-sm font-black text-gray-600 leading-tight">{{ $record->product_name }}</h4>
    </div>

    {{-- 1. Progress Bar Utama --}}
    @php
        $percent = match ($record->status) {
            'Waiting'    => 5,
            'Cutting'    => 25,
            'Sewing'     => 50,
            'QC/Packing' => 75,
            'Done'       => 100,
            default      => 0,
        };
        $barColor = match ($record->status) {
            'Cutting'    => '#EAB308', 
            'Sewing'     => '#0EA5E9', 
            'QC/Packing' => '#A855F7', 
            'Done'       => '#10B981', 
            default      => '#D1D5DB',
        };
    @endphp
    <div class="space-y-1.5 mb-4">
        <div class="flex justify-between items-center text-[9px] font-bold">
            <span class="text-gray-500 italic">Progres Tahapan</span>
            <span class="dark:text-gray-800">{{ $percent }}%</span>
        </div>
        <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
            <div
                style="background-color: {{ $barColor }}; width: {{ $percent }}%;"
                class="h-full rounded-full transition-all duration-700">
            </div>
        </div>
    </div>

    {{-- 2. Progress Fisik --}}
    @if(in_array($record->status, ['Sewing', 'QC/Packing']))
        @php
            $targetStage = $record->status;
            $displayLabel = $record->status === 'Sewing' ? 'Jahit' : 'QC & Packing';
            $totalOutput = $record->outputs()->where('stage', $targetStage)->sum('qty') ?? 0;
            $qtyOrder = $record->quantity > 0 ? $record->quantity : 1;
            $progressPercent = min(($totalOutput / $qtyOrder) * 100, 100);
        @endphp

        <div class="mt-2 mb-4 p-2 bg-gray-50 rounded-xl border border-gray-100">
            <div class="flex justify-between mb-1">
                <span class="text-[10px] font-bold text-gray-500 uppercase font-mono">Setoran {{ $displayLabel }}:</span>
                <span class="text-[10px] font-bold {{ $totalOutput >= $record->quantity ? 'text-green-600' : 'text-primary-600' }}">
                    {{ $totalOutput }} / {{ $record->quantity }} Pcs
                </span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-1.5">
                <div class="h-1.5 rounded-full transition-all duration-500" 
                        style="width: {{ $progressPercent }}%; background-color: {{ $statusColors['text'] }}">
                </div>
            </div>
        </div>
    @endif

    {{-- Footer --}}
    <div class="flex justify-between items-center pt-3 pb-3 border-t border-gray-50">
        <div class="flex items-center gap-2">
            <div class="flex items-center gap-1 bg-gray-50 px-2 py-1 rounded-md border border-gray-100">
                <x-heroicon-o-cube class="w-3 h-3 text-gray-400" />
                <span class="text-[10px] font-bold text-gray-600">
                    {{ $record->quantity }} <span class="font-normal text-[9px]">pcs</span>
                </span>
            </div>
        </div>
        <div class="flex items-center gap-1 bg-slate-50 px-2 py-0.5 rounded-full border border-slate-100">
            <span class="text-[6px] font-bold dark:text-gray-500 text-slate-500 uppercase">
                {{ Str::limit($record->client_name, 12) }}
            </span>
        </div>
    </div>

    {{-- Logic Tombol Interaktif --}}
    <div class="mt-5 pt-2 border-t border-gray-50">
        @php
            // Pastikan pengecekan log menggunakan realId
            $isProcessing = \App\Models\ProductionLog::where('order_id', $realId)
                            ->where('stage', $record->status)
                            ->where('status', 'Sedang Diproses')
                            ->exists();
        @endphp

        @if($isDone)
            <div class="w-full py-1.5 px-3 text-[9px] font-black text-center rounded-lg border border-dashed flex items-center justify-center gap-1 mb-2"
                style="background-color: #a2ffcf; color: #007755; border-color: #a7f3d0;">
                <x-heroicon-s-check-badge class="w-3.5 h-3.5"/> PESANAN SELESAI
            </div>

            @if($user->hasAnyRole(['Owner', 'Admin']))
                <button wire:click="mountAction('selesaiTotalAction', {recordId: {{ $realId }}})"
                wire:loading.attr="disabled"
                        class="w-full text-white text-[8px] font-bold py-1.5 px-3 rounded-lg flex items-center justify-center gap-2 shadow-sm transition hover:brightness-90 uppercase"
                        style="background-color: #05b47d;"> ARSIPKAN / REPEAT ORDER 
                </button>
            @endif

        @elseif($canAction)
            @if($record->status === 'Waiting')
                <button wire:click="confirmToCutting({{ $realId }})"
                        wire:loading.attr="disabled"
                        class="w-full text-white text-[9px] font-bold py-1.5 px-3 rounded-lg transition-all flex items-center justify-center gap-2 shadow-sm uppercase"
                        style="background-color: #263246;">
                    KONFIRMASI KE POTONG <x-heroicon-s-arrow-right class="w-3 h-3"/>
                </button>
            @else
                @if(!$isProcessing)
                    @php
                        $clickAction = $record->status === 'Cutting' ? "mountAction('startCutting', {recordId: {$realId}})" : "startStage({$realId})";
                    @endphp
                    <button wire:click="{{ $clickAction }}" 
                            wire:loading.attr="disabled"
                            class="w-full text-white text-[9px] font-extrabold py-1.5 px-3 rounded-lg shadow-md uppercase tracking-tight flex items-center justify-center gap-2 hover:brightness-90 transition"
                            style="background-color: {{ $statusColors['text'] ?? '#374151' }};">
                        <x-heroicon-s-play class="w-3 h-3"/> Mulai {{ $actionLabel ?? $record->status }}
                    </button>
                @else
                    <div class="flex flex-col gap-2">
                        <div class="flex items-center justify-center gap-1.5 py-1 px-3 border rounded-md" style="border-color: #fcecab; background-color: #fffbeb;">
                            <span class="text-[8px] font-black uppercase italic" style="color: #f59e0b;">Sedang {{ $actionLabel ?? $record->status }}</span>
                        </div>
                        
                        @if(in_array($record->status, ['Sewing', 'QC/Packing']))
                            {{-- PENTING: Untuk cicilHasil, kita kirim ID MENTAH (bisa string shadow) agar PHP bisa membedakan stage-nya --}}
                            <button wire:click="mountAction('cicilHasil', {recordId: '{{ $record->id }}'})"
                                    wire:loading.attr="disabled"
                                    class="w-full text-[9px] font-bold py-1.5 px-3 rounded-lg flex items-center justify-center text-white shadow-md gap-2" 
                                    style="background-color: #0ea5e9;">
                                <x-heroicon-s-plus-circle class="w-3.5 h-3.5"/> CICIL HASIL
                            </button>
                        @endif
                        @php
                            $actionName = ($record->status == 'Cutting') ? 'finishCutting' : 'finishStage';
                        @endphp
                        <button wire:click="mountAction('{{ $actionName }}', {recordId: {{ $realId }}})"
                            wire:loading.attr="disabled"
                            class="w-full text-[9px] font-bold py-1.5 px-3 rounded-lg flex items-center justify-center text-white shadow-md gap-2 hover:bg-[#047857]" style="background-color: #05b47d;">
                            <x-heroicon-s-check-circle class="w-3.5 h-3.5"/> SELESAI TAHAP INI
                        </button>
                    </div>
                @endif
            @endif
        @else
            <div class="flex items-center justify-center gap-1.5 py-2 px-3 border border-dashed rounded-lg opacity-80"
                style="border-color: {{ $statusColors['text'] }}66; background-color: {{ $statusColors['bg'] }};">
                <x-heroicon-m-clock class="w-3 h-3" style="color: {{ $statusColors['text'] }};" />
                <span class="text-[9px] font-black uppercase tracking-wider" style="color: {{ $statusColors['text'] }};">
                    Sedang {{ $statusColors['label'] }}
                </span>
            </div>
        @endif
    </div>
</div>