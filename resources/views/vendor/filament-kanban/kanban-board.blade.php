<x-filament-panels::page>
    <div 
        x-data="{
            scrollToStage() {
                const role = '{{ auth()->user()->roles->first()->name ?? '' }}';
                let targetId = '';

                if (role === 'Cutting') targetId = 'status-Cutting';
                if (role === 'Tailor') targetId = 'status-Sewing';
                if (role === 'QC/Packing') targetId = 'status-QC/Packing';

                if (targetId) {
                    const el = document.getElementById(targetId);
                    if (el) {
                        el.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
                    }
                }
            }
        }" 
        x-init="setTimeout(() => scrollToStage(), 500)"
        wire:ignore.self 
        {{-- items-stretch adalah kunci agar semua kolom tingginya sama --}}
        class="flex flex-nowrap overflow-x-auto overflow-y-hidden gap-4 pb-10 snap-x snap-mandatory items-stretch"
        style="WebkitOverflowScrolling: touch;"
    >
        @foreach($statuses as $status)
            {{-- Tambahkan flex dan flex-col agar kolom bisa memanjang secara dinamis --}}
            <div 
                id="status-{{ $status['id'] }}" 
                class="snap-center shrink-0 w-[85vw] md:w-[350px] flex flex-col"
            >
                <div class="bg-gray-50 dark:bg-white/5 rounded-xl border border-gray-200 dark:border-white/10 flex flex-col flex-1 shadow-sm">
                    @include(static::$statusView)
                </div>
            </div>
        @endforeach

        <div wire:ignore class="flex">
            @include(static::$scriptsView)
        </div>
    </div>

    @unless($disableEditModal)
        <x-filament-kanban::edit-record-modal/>
    @endunless
</x-filament-panels::page>