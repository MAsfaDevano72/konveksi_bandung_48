<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-3xl">
        Tracking Produksi
    </h1>

    <x-filament-actions::actions :actions="$this->getHeaderActions()" />
</div>

<style>
    /* Paksa grid widget menggunakan 5 kolom murni */
    .fi-wi-stats-overview > div {
        grid-template-columns: repeat(5, minmax(0, 1fr)) !important;
        gap: 0.75rem !important; /* Perkecil jarak antar kartu */
    }

    /* Kecilkan padding di dalam kartu agar muat */
    .fi-wi-stats-overview-stat-card {
        padding: 1rem !important; 
    }

    /* Kecilkan ukuran angka sedikit */
    .fi-wi-stats-overview-stat-value {
        font-size: 1.5rem !important;
        line-height: 1.75rem !important;
    }

    /* Sembunyikan deskripsi jika layar agak kecil agar tetap rapi */
    @media (max-width: 1280px) {
        .fi-wi-stats-overview-stat-description {
            display: none;
        }
    }

    @media (max-width: 640px) {
        .fi-wi-stats-overview > div {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 0.5rem !important;
        }
        
        /* Opsional: Buat kartu terakhir jadi full width agar pas jadi 3 baris */
        .fi-wi-stats-overview > div > :last-child {
            grid-column: span 2 !important;
        }

        .fi-wi-stats-overview-stat-value {
            font-size: 1.25rem !important; /* Sesuaikan ukuran font di HP */
        }
    }
</style>