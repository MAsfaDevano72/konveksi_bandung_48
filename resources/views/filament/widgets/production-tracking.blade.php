<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex flex-col gap-y-3">
            <h2 class="text-lg font-bold tracking-tight">Tracking Produksi</h2>
            <p class="text-sm text-gray-500">Status real-time semua pesanan di lantai produksi</p>
            
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mt-2">
                
                <div class="flex items-center justify-between p-4 rounded-xl border shadow-sm"
                style="background-color: #f3f4f6; border-color: #bdbebe;">
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-clock class="w-5 h-5 text-gray-600" />
                        <span class="font-bold text-gray-700">Menunggu</span>
                    </div>
                    <span class="flex items-center justify-center w-8 h-8 text-xs font-bold text-white bg-gray-400 rounded-full">
                        {{ $waiting }}
                    </span>
                </div>

                <div class="flex items-center justify-between p-4 rounded-xl border shadow-sm"
                style="background-color: #fff7ed; border-color: #fad2a3;">
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-scissors class="w-5 h-5" style="color: #ea580c;"/>
                        <span class="font-bold " style="color: #c2410c;">Potong</span>
                    </div>
                    <span class="flex items-center justify-center w-8 h-8 text-xs font-bold rounded-full"
                    style="background-color: #f97316; color: white;">
                        {{ $cutting }}
                    </span>
                </div>

                <div class="flex items-center justify-between p-4 rounded-xl border shadow-sm"
                style="background-color: #dbeafe; border-color: #9dbee7;">
                    <div class="flex items-center gap-2" style="color: #2563eb;">
                        <x-heroicon-o-receipt-percent class="w-5 h-5" />
                        <span class="font-bold">Jahit</span>
                    </div>
                    <span class="flex items-center justify-center w-8 h-8 text-xs font-bold text-white rounded-full"
                    style="background-color: #3b82f6">
                        {{ $sewing }}
                    </span>
                </div>

                <div class="flex items-center justify-between p-4 rounded-xl border shadow-sm"
                style="background-color: #f0e6fa; border-color: #dfc7fa;">
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-archive-box class="w-5 h-5" style="color: #9333ea;"/>
                        <span class="font-bold" style="color: #7e22ce; ">Packing</span>
                    </div>
                    <span class="flex items-center justify-center w-8 h-8 text-xs font-bold text-whit rounded-full" style="background-color: #a855f7; color: white;">
                        {{ $packing }}
                    </span>
                </div>

                <div class="flex items-center justify-between p-4 rounded-xl border shadow-sm"
                style="background-color: #f0fdf4; border-color: #b1f1d0;">
                    <div class="flex items-center gap-2">
                        <x-heroicon-o-check-circle class="w-5 h-5" style="color: #16a34a;"/>
                        <span class="font-bold" style="color: #15803d;">Selesai</span>
                    </div>
                    <span class="flex items-center justify-center w-8 h-8 text-xs font-bold text-white rounded-full" style="background-color: #22c55e;">
                        {{ $done }}
                    </span>
                </div>

            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>