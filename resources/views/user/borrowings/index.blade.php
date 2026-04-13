{{-- resources/views/user/borrowings/index.blade.php --}}
@extends('layouts.user')

@section('title', 'Riwayat Peminjaman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h4 class="fw-bold mb-1" style="color: var(--color-30);">
            <i class="bi bi-clock-history me-2" style="color: var(--color-10);"></i>Riwayat Peminjaman
        </h4>
        <p class="text-muted mb-0 small">Lihat riwayat peminjaman buku Anda</p>
    </div>
    <div class="text-muted">
        <i class="bi bi-journal-bookmark-fill me-1"></i> 
        <span class="fw-semibold">{{ $borrowings->count() }}</span> Transaksi
    </div>
</div>

<div class="glass-table-container">
    <div class="table-responsive">
        <table class="premium-table">
            <thead>
                <tr>
                    <th style="width: 5%;">NO</th>
                    <th>JUDUL BUKU</th>
                    <th>STATUS</th>
                    <th>TANGGAL PINJAM</th>
                    <th>TANGGAL KEMBALI</th>
                    <th style="width: 15%;" class="text-center">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($borrowings as $index => $pinjam)
                <tr>
                    <td class="fw-semibold">{{ $loop->iteration }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: rgba(212, 163, 115, 0.15);">
                                <i class="bi bi-book" style="color: var(--color-10);"></i>
                            </div>
                            <div>
                                <strong class="text-dark">{{ $pinjam->book->title }}</strong><br>
                                <small class="text-muted">Penulis: {{ $pinjam->book->author }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($pinjam->status == 'dipinjam')
                            <span class="badge-warning">
                                <i class="bi bi-book-half me-1"></i> Dipinjam
                            </span>
                        @elseif($pinjam->status == 'menunggu')
                            <span class="badge-info">
                                <i class="bi bi-clock-history me-1"></i> Menunggu
                            </span>
                        @else
                            <span class="badge-success">
                                <i class="bi bi-check-circle me-1"></i> Selesai
                            </span>
                        @endif
                    </td>
                    <td>
                        <span class="text-dark">
                            <i class="bi bi-calendar me-1" style="color: var(--color-10);"></i>
                            {{ \Carbon\Carbon::parse($pinjam->borrowed_date)->translatedFormat('d F Y') }}
                        </span>
                    </td>
                    <td>
                        @if($pinjam->return_date)
                            <span class="text-success">
                                <i class="bi bi-check-circle-fill me-1"></i>
                                {{ \Carbon\Carbon::parse($pinjam->return_date)->translatedFormat('d F Y') }}
                            </span>
                        @else
                            <span class="text-muted">
                                <i class="bi bi-dash-circle me-1"></i> -
                            </span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($pinjam->status == 'dipinjam')
                            <form action="{{ route('user.kembali', $pinjam->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn-primary-glass" style="padding: 0.4rem 1rem; font-size: 0.85rem;" onclick="return confirm('Yakin ingin mengembalikan buku {{ $pinjam->book->title }}?')">
                                    <i class="bi bi-arrow-return-left me-1"></i> Kembalikan
                                </button>
                            </form>
                        @elseif($pinjam->status == 'menunggu')
                            <span class="badge" style="background: #F3F4F6; color: #6B7280; padding: 0.35rem 0.85rem; border-radius: 30px; font-weight: 500;">
                                <i class="bi bi-hourglass-split me-1"></i> Menunggu Konfirmasi
                            </span>
                        @else
                            <span class="badge-success">
                                <i class="bi bi-check-all me-1"></i> Selesai
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="empty-state py-4">
                            <div class="empty-icon-box mx-auto mb-3">
                                <i class="bi bi-inbox fs-1"></i>
                            </div>
                            <h5 class="fw-semibold mb-2" style="color: var(--color-30);">Belum Ada Transaksi</h5>
                            <p class="text-muted mb-3 small">Anda belum melakukan peminjaman buku apapun.</p>
                            <a href="{{ route('user.books') }}" class="btn-primary-glass">
                                <i class="bi bi-book-half me-2"></i> Jelajahi Buku
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@php
    $totalDipinjam = $borrowings->where('status', 'dipinjam')->count();
    $totalMenunggu = $borrowings->where('status', 'menunggu')->count();
    $totalSelesai = $borrowings->where('status', 'selesai')->count();
@endphp

@if($borrowings->count() > 0)
<div class="row mt-4 g-4">
    <div class="col-md-4">
        <div class="stat-card text-center">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted text-uppercase">Total Peminjaman</small>
                    <h2 class="fw-bold mb-0 mt-2" style="color: var(--color-30); font-size: 2.618rem;">{{ $borrowings->count() }}</h2>
                </div>
                <div class="rounded-3 p-3" style="background: rgba(44, 62, 80, 0.1);">
                    <i class="bi bi-journal-bookmark-fill fs-2" style="color: var(--color-30);"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card text-center">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted text-uppercase">Sedang Dipinjam</small>
                    <h2 class="fw-bold mb-0 mt-2" style="color: var(--color-10); font-size: 2.618rem;">{{ $totalDipinjam }}</h2>
                </div>
                <div class="rounded-3 p-3" style="background: rgba(212, 163, 115, 0.15);">
                    <i class="bi bi-book-half fs-2" style="color: var(--color-10);"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card text-center">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted text-uppercase">Selesai</small>
                    <h2 class="fw-bold mb-0 mt-2" style="color: var(--color-30-light); font-size: 2.618rem;">{{ $totalSelesai }}</h2>
                </div>
                <div class="rounded-3 p-3" style="background: rgba(61, 81, 102, 0.1);">
                    <i class="bi bi-check-circle fs-2" style="color: var(--color-30-light);"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection