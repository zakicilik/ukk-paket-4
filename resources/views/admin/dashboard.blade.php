{{-- resources/views/admin/dashboard/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold mb-1" style="color: var(--color-30);">
        <i class="bi bi-speedometer2 me-2" style="color: var(--color-10);"></i>Dashboard Admin
    </h3>
    <p class="text-muted mb-0 small">Selamat datang di panel administrator perpustakaan digital</p>
</div>

{{-- Statistik Cards --}}
<div class="row g-4 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted text-uppercase">Total Buku</small>
                    <h2 class="fw-bold mb-0 mt-2" style="color: var(--color-30); font-size: 2.618rem;">{{ $books ?? 0 }}</h2>
                </div>
                <div class="rounded-3 p-3" style="background: rgba(212, 163, 115, 0.15);">
                    <i class="bi bi-book fs-1" style="color: var(--color-10);"></i>
                </div>
            </div>
            <div class="mt-3">
                <small class="text-muted">
                    <i class="bi bi-collection me-1"></i> Koleksi perpustakaan
                </small>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted text-uppercase">Total Anggota</small>
                    <h2 class="fw-bold mb-0 mt-2" style="color: var(--color-30); font-size: 2.618rem;">{{ $users ?? 0 }}</h2>
                </div>
                <div class="rounded-3 p-3" style="background: rgba(212, 163, 115, 0.15);">
                    <i class="bi bi-people fs-1" style="color: var(--color-10);"></i>
                </div>
            </div>
            <div class="mt-3">
                <small class="text-muted">
                    <i class="bi bi-person-plus me-1"></i> Terdaftar aktif
                </small>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted text-uppercase">Total Transaksi</small>
                    <h2 class="fw-bold mb-0 mt-2" style="color: var(--color-30); font-size: 2.618rem;">{{ $borrowings ?? 0 }}</h2>
                </div>
                <div class="rounded-3 p-3" style="background: rgba(212, 163, 115, 0.15);">
                    <i class="bi bi-arrow-left-right fs-1" style="color: var(--color-10);"></i>
                </div>
            </div>
            <div class="mt-3">
                <small class="text-muted">
                    <i class="bi bi-clock-history me-1"></i> Peminjaman & pengembalian
                </small>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted text-uppercase">Sedang Dipinjam</small>
                    <h2 class="fw-bold mb-0 mt-2" style="color: var(--color-10); font-size: 2.618rem;">{{ $activeBorrowings ?? 0 }}</h2>
                </div>
                <div class="rounded-3 p-3" style="background: rgba(212, 163, 115, 0.15);">
                    <i class="bi bi-book-half fs-1" style="color: var(--color-10);"></i>
                </div>
            </div>
            <div class="mt-3">
                <small class="text-muted">
                    <i class="bi bi-exclamation-triangle me-1"></i> Belum dikembalikan
                </small>
            </div>
        </div>
    </div>
</div>

{{-- Info Footer --}}
<div class="row mt-4">
    <div class="col-12">
        <div class="glass-card p-3" style="background: rgba(212, 163, 115, 0.05);">
            <div class="d-flex align-items-center gap-3 flex-wrap">
                <i class="bi bi-info-circle-fill fs-4" style="color: var(--color-10);"></i>
                <div class="flex-grow-1">
                    <small class="text-muted">Informasi Sistem</small>
                    <p class="mb-0 small text-dark">
                        Last login: {{ now()->translatedFormat('d F Y H:i:s') }} | 
                        IP: {{ request()->ip() }} | 
                        Laravel {{ app()->version() }}
                    </p>
                </div>
                <button class="btn-outline-glass" onclick="window.location.reload()">
                    <i class="bi bi-arrow-repeat me-1"></i> Refresh
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --color-60: #F5F0E8;
        --color-30: #2C3E50;
        --color-30-dark: #1A2A3A;
        --color-10: #D4A373;
        --color-10-dark: #C28A5A;
        --border-light: rgba(44, 62, 80, 0.1);
    }
    
    .stat-card {
        background: white;
        border-radius: 21px;
        border: 1px solid var(--border-light);
        padding: 1.3rem;
        transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }
    
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 28px rgba(0, 0, 0, 0.12);
    }
    
    .glass-card {
        background: white;
        border-radius: 21px;
        border: 1px solid var(--border-light);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
    }
    
    .glass-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }
    
    .btn-outline-glass {
        background: transparent;
        border: 1px solid var(--border-light);
        border-radius: 13px;
        padding: 0.4rem 1rem;
        font-size: 0.85rem;
        color: var(--color-30);
        transition: 0.2s;
    }
    
    .btn-outline-glass:hover {
        background: rgba(212, 163, 115, 0.1);
        border-color: var(--color-10);
        color: var(--color-10);
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
    
    .row > .col-md-3 {
        animation: fadeIn 0.5s ease forwards;
    }
    
    .row > .col-md-3:nth-child(1) { animation-delay: 0.1s; }
    .row > .col-md-3:nth-child(2) { animation-delay: 0.2s; }
    .row > .col-md-3:nth-child(3) { animation-delay: 0.3s; }
    .row > .col-md-3:nth-child(4) { animation-delay: 0.4s; }
</style>
@endsection