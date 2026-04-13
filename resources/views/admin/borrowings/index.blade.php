{{-- resources/views/admin/borrowings/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Data Transaksi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h3 class="fw-bold mb-1" style="color: var(--color-30);">
            <i class="bi bi-arrow-left-right me-2" style="color: var(--color-10);"></i>Data Transaksi Peminjaman
        </h3>
        <p class="text-muted mb-0 small">Kelola seluruh transaksi peminjaman dan pengembalian buku</p>
    </div>
    <div>
        <span class="badge" style="background: rgba(212, 163, 115, 0.15); color: var(--color-10-dark); padding: 0.5rem 1rem; border-radius: 30px;">
            <i class="bi bi-book me-1"></i> Total: {{ $borrowings->count() }}
        </span>
    </div>
</div>

<div class="card-table">
    <div class="table-responsive">
        <table class="table-custom">
            <thead>
                <tr>
                    <th style="width: 5%;">NO</th>
                    <th>PEMINJAM</th>
                    <th>JUDUL BUKU</th>
                    <th>STATUS</th>
                    <th>TANGGAL PINJAM</th>
                    <th>TANGGAL KEMBALI</th>
                    <th style="width: 18%;" class="text-center">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($borrowings as $index => $b)
                <tr>
                    <td class="fw-semibold">{{ $loop->iteration }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; background: rgba(212, 163, 115, 0.15);">
                                <i class="bi bi-person" style="color: var(--color-10); font-size: 0.9rem;"></i>
                            </div>
                            <strong class="text-dark">{{ $b->user->name }}</strong>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; background: rgba(212, 163, 115, 0.15);">
                                <i class="bi bi-book" style="color: var(--color-10); font-size: 0.9rem;"></i>
                            </div>
                            <span class="text-dark">{{ Str::limit($b->book->title, 40) }}</span>
                        </div>
                    </td>
                    <td>
                        @if($b->status == 'menunggu')
                            <span class="badge-warning">
                                <i class="bi bi-clock-history me-1"></i> Menunggu
                            </span>
                        @elseif($b->status == 'dipinjam')
                            <span class="badge-info">
                                <i class="bi bi-book-half me-1"></i> Dipinjam
                            </span>
                        @elseif($b->status == 'dikembalikan')
                            <span class="badge-success">
                                <i class="bi bi-check-circle me-1"></i> Dikembalikan
                            </span>
                        @else
                            <span class="badge" style="background: #F3F4F6; color: #6B7280; padding: 0.35rem 0.85rem; border-radius: 30px; font-weight: 500;">
                                <i class="bi bi-question-circle me-1"></i> {{ $b->status }}
                            </span>
                        @endif
                    </td>
                    <td>
                        <span class="text-dark">
                            <i class="bi bi-calendar me-1" style="color: var(--color-10);"></i> 
                            {{ \Carbon\Carbon::parse($b->borrowed_date)->translatedFormat('d F Y') }}
                        </span>
                    </td>
                    <td>
                        @if($b->return_date)
                            <span class="text-success">
                                <i class="bi bi-check-circle-fill me-1"></i> 
                                {{ \Carbon\Carbon::parse($b->return_date)->translatedFormat('d F Y') }}
                            </span>
                        @else
                            <span class="text-muted">
                                <i class="bi bi-dash-circle me-1"></i> -
                            </span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="btn-group" role="group" style="gap: 6px; justify-content: center;">
                            @if($b->status == 'menunggu')
                                <form action="{{ route('admin.borrowings.approve', $b->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn-outline-glass" style="padding: 0.35rem 0.85rem; background: rgba(212, 163, 115, 0.1); border-color: var(--color-10); color: var(--color-10-dark);" onclick="return confirm('Setujui peminjaman ini?')">
                                        <i class="bi bi-check-lg me-1"></i> Setujui
                                    </button>
                                </form>
                            @endif

                            @if($b->status == 'dipinjam')
                                <form action="{{ route('admin.borrowings.update', $b->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn-outline-glass" style="padding: 0.35rem 0.85rem; background: rgba(13, 202, 240, 0.1); border-color: #0DCAF0; color: #0DCAF0;" onclick="return confirm('Kembalikan buku ini?')">
                                        <i class="bi bi-arrow-return-left me-1"></i> Kembalikan
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('admin.borrowings.destroy', $b->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-outline-glass" style="padding: 0.35rem 0.85rem; background: rgba(220, 53, 69, 0.1); border-color: #DC3545; color: #DC3545;" onclick="return confirm('Hapus transaksi ini?')">
                                    <i class="bi bi-trash me-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div class="empty-state py-4">
                            <div class="empty-icon-box mx-auto mb-3">
                                <i class="bi bi-inbox fs-1"></i>
                            </div>
                            <h5 class="fw-semibold mb-2" style="color: var(--color-30);">Belum Ada Transaksi</h5>
                            <p class="text-muted mb-3 small">Belum ada transaksi peminjaman buku.</p>
                            <span class="badge" style="background: rgba(212, 163, 115, 0.15); color: var(--color-10-dark); padding: 0.5rem 1rem; border-radius: 30px;">
                                <i class="bi bi-database-slash me-1"></i> 0 Transaksi
                            </span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Pagination --}}
@if(method_exists($borrowings, 'links') && $borrowings->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $borrowings->links() }}
    </div>
@endif

{{-- Statistik Ringkas --}}
@php
    $totalTransaksi = $borrowings->count();
    $totalDipinjam = $borrowings->where('status', 'dipinjam')->count();
    $totalMenunggu = $borrowings->where('status', 'menunggu')->count();
    $totalDikembalikan = $borrowings->where('status', 'dikembalikan')->count();
@endphp

<div class="row mt-4 g-4">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted text-uppercase">Total Transaksi</small>
                    <h2 class="fw-bold mb-0 mt-2" style="color: var(--color-30); font-size: 2.618rem;">{{ $totalTransaksi }}</h2>
                </div>
                <div class="rounded-3 p-3" style="background: rgba(212, 163, 115, 0.15);">
                    <i class="bi bi-receipt fs-2" style="color: var(--color-10);"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted text-uppercase">Menunggu</small>
                    <h2 class="fw-bold mb-0 mt-2" style="color: var(--color-30); font-size: 2.618rem;">{{ $totalMenunggu }}</h2>
                </div>
                <div class="rounded-3 p-3" style="background: rgba(212, 163, 115, 0.15);">
                    <i class="bi bi-clock-history fs-2" style="color: var(--color-10);"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted text-uppercase">Dipinjam</small>
                    <h2 class="fw-bold mb-0 mt-2" style="color: var(--color-10); font-size: 2.618rem;">{{ $totalDipinjam }}</h2>
                </div>
                <div class="rounded-3 p-3" style="background: rgba(212, 163, 115, 0.15);">
                    <i class="bi bi-book-half fs-2" style="color: var(--color-10);"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted text-uppercase">Dikembalikan</small>
                    <h2 class="fw-bold mb-0 mt-2" style="color: var(--color-30); font-size: 2.618rem;">{{ $totalDikembalikan }}</h2>
                </div>
                <div class="rounded-3 p-3" style="background: rgba(212, 163, 115, 0.15);">
                    <i class="bi bi-check-circle fs-2" style="color: var(--color-10);"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection