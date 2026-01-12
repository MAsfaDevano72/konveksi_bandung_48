<x-filament-panels::page>
    <form wire:submit.prevent="save">
        {{ $this->form }}

        <div class="mt-6 text-right">
            <x-filament::button type="submit" size="lg">
                Simpan Perubahan
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>