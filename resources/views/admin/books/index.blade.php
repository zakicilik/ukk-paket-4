{{-- resources/views/admin/books/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Manajemen Buku')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h3 class="fw-bold mb-1" style="color: var(--color-30);">
            <i class="bi bi-book-half me-2" style="color: var(--color-10);"></i>Data Koleksi Buku
        </h3>
        <p class="text-muted mb-0 small">Kelola seluruh koleksi buku perpustakaan digital</p>
    </div>
    <a href="{{ route('admin.books.create') }}" class="btn-primary-glass">
        <i class="bi bi-plus-circle me-2"></i>Tambah Buku Baru
    </a>
</div>

<div class="card-table">
    <div class="table-responsive">
        <table class="table-custom">
            <thead>
                <tr>
                    <th style="width: 5%;">#</th>
                    <th>INFORMASI BUKU</th>
                    <th>PENERBIT & TAHUN</th>
                    <th>STOK</th>
                    <th style="width: 18%;" class="text-center">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $index => $book)
                <tr>
                    <td class="fw-semibold">{{ $loop->iteration }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background: rgba(212, 163, 115, 0.15);">
                                <i class="bi bi-book" style="color: var(--color-10); font-size: 1.2rem;"></i>
                            </div>
                            <div>
                                <strong class="text-dark">{{ Str::limit($book->title, 40) }}</strong><br>
                                <small class="text-muted"><i class="bi bi-pencil me-1"></i>Penulis: {{ $book->author }}</small><br>
                                <small class="text-muted"><i class="bi bi-upc-scan me-1"></i>ISBN: {{ $book->isbn ?? '-' }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($book->publisher || $book->publication_year)
                            <span class="badge" style="background: rgba(212, 163, 115, 0.15); color: var(--color-10-dark); padding: 0.35rem 0.85rem; border-radius: 30px;">
                                <i class="bi bi-building me-1"></i> {{ $book->publisher ?? '-' }}
                            </span>
                            <br>
                            <small class="text-muted mt-1 d-inline-block">
                                <i class="bi bi-calendar me-1"></i>Thn: {{ $book->publication_year ?? '-' }}
                            </small>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        @if($book->stock <= 0)
                            <span class="badge-danger">
                                <i class="bi bi-x-circle me-1"></i> Habis
                            </span>
                        @elseif($book->stock <= 5)
                            <span class="badge-warning">
                                <i class="bi bi-exclamation-triangle me-1"></i> Sisa: {{ $book->stock }}
                            </span>
                        @else
                            <span class="badge-success">
                                <i class="bi bi-check-circle me-1"></i> {{ $book->stock }} Eksemplar
                            </span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="btn-group" role="group" style="gap: 6px; justify-content: center;">
                            <a href="{{ route('admin.books.edit', $book->id) }}"
                               class="btn-outline-glass" style="padding: 0.35rem 0.85rem; background: rgba(212, 163, 115, 0.1); border-color: var(--color-10); color: var(--color-10-dark);">
                                <i class="bi bi-pencil-square me-1"></i> Edit
                            </a>

                            <form action="{{ route('admin.books.destroy', $book->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?')"
                                  style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn-outline-glass" style="padding: 0.35rem 0.85rem; background: rgba(220, 53, 69, 0.1); border-color: #DC3545; color: #DC3545;">
                                    <i class="bi bi-trash me-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5">
                        <div class="empty-state py-4">
                            <div class="empty-icon-box mx-auto mb-3">
                                <i class="bi bi-journal-bookmark-fill fs-1"></i>
                            </div>
                            <h5 class="fw-semibold mb-2" style="color: var(--color-30);">Belum Ada Data Buku</h5>
                            <p class="text-muted mb-3 small">Koleksi buku masih kosong. Silakan tambah buku baru melalui tombol di atas.</p>
                            <span class="badge" style="background: rgba(212, 163, 115, 0.15); color: var(--color-10-dark); padding: 0.5rem 1rem; border-radius: 30px;">
                                <i class="bi bi-database-slash me-1"></i> 0 Buku Tersimpan
                            </span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Pagination Links --}}
@if($books instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator && $books->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $books->links() }}
    </div>
@endif

{{-- Statistik ringkas --}}
@php
    $totalBuku = $books->count();
    $totalStok = $books->sum('stock');
    $stokHabis = $books->where('stock', 0)->count();
@endphp

<div class="row mt-4 g-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted text-uppercase">Total Buku</small>
                    <h2 class="fw-bold mb-0 mt-2" style="color: var(--color-30); font-size: 2.618rem;">{{ $totalBuku }}</h2>
                </div>
                <div class="rounded-3 p-3" style="background: rgba(212, 163, 115, 0.15);">
                    <i class="bi bi-book fs-2" style="color: var(--color-10);"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted text-uppercase">Total Stok</small>
                    <h2 class="fw-bold mb-0 mt-2" style="color: var(--color-30); font-size: 2.618rem;">{{ $totalStok }}</h2>
                </div>
                <div class="rounded-3 p-3" style="background: rgba(212, 163, 115, 0.15);">
                    <i class="bi bi-box-seam fs-2" style="color: var(--color-10);"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted text-uppercase">Stok Habis</small>
                    <h2 class="fw-bold mb-0 mt-2" style="color: var(--color-10); font-size: 2.618rem;">{{ $stokHabis }}</h2>
                </div>
                <div class="rounded-3 p-3" style="background: rgba(212, 163, 115, 0.15);">
                    <i class="bi bi-exclamation-triangle fs-2" style="color: var(--color-10);"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection