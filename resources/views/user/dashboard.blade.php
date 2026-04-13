{{-- resources/views/user/dashboard.blade.php --}}
@extends('layouts.user')

@section('title', 'Dashboard Member')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold mb-1" style="color: var(--color-30);">
        <i class="bi bi-speedometer2 me-2" style="color: var(--color-10);"></i>Dashboard Member
    </h3>
    <p class="text-muted mb-0 small">Selamat datang di panel anggota perpustakaan digital</p>
</div>

{{-- Statistik Cards --}}
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 rounded-4 shadow-sm h-100" style="background: linear-gradient(135deg, var(--color-30) 0%, var(--color-30-dark) 100%);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-white-50 text-uppercase">Total Buku</small>
                        <h2 class="fw-bold mb-0 text-white mt-2" style="font-size: 2.618rem;">{{ $books->count() }}</h2>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-3 p-3">
                        <i class="bi bi-book fs-1 text-white"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <small class="text-white-50">
                        <i class="bi bi-collection me-1"></i> Koleksi perpustakaan
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 rounded-4 shadow-sm h-100" style="background: linear-gradient(135deg, var(--color-10) 0%, var(--color-10-dark) 100%);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-white-50 text-uppercase">Sedang Dipinjam</small>
                        <h2 class="fw-bold mb-0 text-white mt-2" style="font-size: 2.618rem;">{{ $borrowings->where('status', 'dipinjam')->count() }}</h2>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-3 p-3">
                        <i class="bi bi-book-half fs-1 text-white"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <small class="text-white-50">
                        <i class="bi bi-clock-history me-1"></i> Belum dikembalikan
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 rounded-4 shadow-sm h-100" style="background: linear-gradient(135deg, var(--color-30-light) 0%, var(--color-30) 100%);">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-white-50 text-uppercase">Sudah Dikembalikan</small>
                        <h2 class="fw-bold mb-0 text-white mt-2" style="font-size: 2.618rem;">{{ $borrowings->where('status', 'dikembalikan')->count() }}</h2>
                    </div>
                    <div class="bg-white bg-opacity-25 rounded-3 p-3">
                        <i class="bi bi-check-circle fs-1 text-white"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <small class="text-white-50">
                        <i class="bi bi-arrow-return-left me-1"></i> Selesai dipinjam
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Selamat Datang Card --}}
<div class="glass-card p-4 mb-4">
    <div class="d-flex align-items-center gap-3 mb-3">
        <div class="rounded-circle p-3" style="background: rgba(212, 163, 115, 0.15);">
            <i class="bi bi-person fs-3" style="color: var(--color-10);"></i>
        </div>
        <div>
            <h5 class="fw-bold mb-0" style="color: var(--color-30);">Selamat Datang, {{ auth()->user()->name }}!</h5>
            <p class="text-muted mb-0 small">Senang melihat Anda kembali di perpustakaan digital</p>
        </div>
    </div>
    <p class="text-secondary mb-0">Anda dapat menjelajahi koleksi buku, melakukan peminjaman, dan melihat riwayat peminjaman melalui menu di samping.</p>
</div>

{{-- Akses Cepat --}}
<div class="mt-4">
    <h4 class="fw-bold mb-3" style="color: var(--color-30);">
        <i class="bi bi-lightning-charge me-2" style="color: var(--color-10);"></i>Akses Cepat
    </h4>
    
    <div class="row g-4">
        <div class="col-md-6">
            <a href="{{ route('user.books') }}" class="text-decoration-none">
                <div class="card border-0 rounded-4 shadow-sm text-center p-4 h-100" style="background: linear-gradient(135deg, var(--color-30) 0%, var(--color-30-light) 100%); transition: all 0.3s ease;">
                    <i class="bi bi-book-half fs-1 text-white mb-3"></i>
                    <h5 class="fw-bold text-white mb-2">Jelajahi Buku</h5>
                    <p class="text-white-50 mb-0 small">Cari dan pinjam buku favorit Anda</p>
                </div>
            </a>
        </div>
        
        <div class="col-md-6">
            <a href="{{ route('user.borrowings') }}" class="text-decoration-none">
                <div class="card border-0 rounded-4 shadow-sm text-center p-4 h-100" style="background: linear-gradient(135deg, var(--color-10) 0%, var(--color-10-dark) 100%); transition: all 0.3s ease;">
                    <i class="bi bi-clock-history fs-1 text-white mb-3"></i>
                    <h5 class="fw-bold text-white mb-2">Riwayat Peminjaman</h5>
                    <p class="text-white-50 mb-0 small">Lihat riwayat peminjaman Anda</p>
                </div>
            </a>
        </div>
    </div>
</div>

<style>
    :root {
        --color-60: #F5F0E8;
        --color-30: #2C3E50;
        --color-30-dark: #1A2A3A;
        --color-30-light: #3D5166;
        --color-10: #D4A373;
        --color-10-dark: #C28A5A;
        --color-10-light: #E6C9A8;
    }
    
    .glass-card {
        background: #ffffff;
        border-radius: 21px;
        border: 1px solid var(--border-light, rgba(44, 62, 80, 0.1));
        box-shadow: var(--card-shadow, 0 4px 12px rgba(0, 0, 0, 0.08));
        transition: all 0.3s ease;
    }
    
    .glass-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--card-shadow-hover, 0 8px 24px rgba(0, 0, 0, 0.12));
    }
    
    .card {
        transition: all 0.3s ease;
        border-radius: 21px !important;
        overflow: hidden;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
    }
    
    /* Golden Ratio Typography untuk angka statistik */
    .card-body h2 {
        font-size: 2.618rem !important;
        letter-spacing: -0.02em;
    }
    
    /* Golden Ratio untuk spacing */
    .gap-3 {
        gap: 1.618rem !important;
    }
    
    .mb-4 {
        margin-bottom: 1.618rem !important;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .row > .col-md-4, .row > .col-md-6 {
        animation: fadeIn 0.4s ease forwards;
    }
    
    .row > .col-md-4:nth-child(1) { animation-delay: 0.05s; }
    .row > .col-md-4:nth-child(2) { animation-delay: 0.1s; }
    .row > .col-md-4:nth-child(3) { animation-delay: 0.15s; }
    .row > .col-md-6:nth-child(1) { animation-delay: 0.2s; }
    .row > .col-md-6:nth-child(2) { animation-delay: 0.25s; }
    
    /* Hover effect untuk akses cepat */
    .row .col-md-6 .card {
        transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    }
    
    .row .col-md-6 .card:hover {
        transform: translateY(-8px);
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-body h2 {
            font-size: 2rem !important;
        }
        
        .glass-card p-4 {
            padding: 1rem !important;
        }
    }
</style>
@endsection