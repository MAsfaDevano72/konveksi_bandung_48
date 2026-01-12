<style>
    /* 1. PERBAIKAN WIDGET STATS (KOTAK KECIL) */
    @media (max-width: 640px) {
        .fi-wi-stats-overview > div {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 0.5rem !important;
        }
        
        .fi-wi-stats-overview-stat-card {
            padding: 0.75rem !important;
        }

        .fi-wi-stats-overview-stat-value {
            font-size: 1.1rem !important; /* Kecilkan angka agar tidak pecah */
        }
        
        .fi-wi-stats-overview-stat-label {
            font-size: 0.75rem !important;
        }
    }

    /* 2. PERBAIKAN WIDGET TABEL (PESANAN TERBARU & STOK RENDAH) */
    @media (max-width: 1024px) {
        .fi-wi-widgets-grid {
            display: flex !important;
            flex-direction: column !important;
            gap: 1.5rem !important;
        }

        /* Memaksa setiap widget mengambil lebar 100% */
        .fi-wi-widget {
            grid-column: span 12 / span 12 !important;
            width: 100% !important;
        }
    }

    /* 3. PERBAIKAN TABEL AGAR BISA DI-SCROLL (TIDAK KURUS) */
    @media (max-width: 640px) {
        .fi-ta-content {
            overflow-x: auto !important;
        }
        
        .fi-ta-table {
            min-width: 600px !important; 
        }
    }

    /* 4. PERBAIKAN TABEL RIWAYAT */
    @media (max-width: 640px) {
        .fi-ta-content {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
        }

        .fi-ta-table {
            min-width: 500px !important;
        }

        .fi-ta-cell {
            padding-inline: 0.5rem !important;
            font-size: 0.75rem !important;
        }
    }

    /* 5. PERBAIKAN HEADER ACTIONS GUDANG */
    @media (max-width: 640px) {
        .fi-header-actions {
            display: flex !important;
            flex-wrap: wrap !important;
            gap: 0.5rem !important;
            justify-content: flex-start !important;
        }

        .fi-header-actions button, 
        .fi-header-actions a {
            flex: 1 1 auto !important; /* Tombol akan menyesuaikan lebar */
            font-size: 0.7rem !important;
            padding: 0.4rem 0.6rem !important;
        }
    }
</style>