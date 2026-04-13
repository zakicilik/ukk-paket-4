{{-- resources/views/admin/books/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Data Buku')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h3 class="fw-bold mb-1" style="color: var(--color-30);">
            <i class="bi bi-pencil-square me-2" style="color: var(--color-10);"></i>Edit Data Buku
        </h3>
        <p class="text-muted mb-0 small">Perbarui informasi koleksi buku perpustakaan</p>
    </div>
    <a href="{{ route('admin.books.index') }}" class="btn-outline-glass">
        <i class="bi bi-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="glass-card p-4">
    <form action="{{ route('admin.books.update', $book->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label fw-semibold" style="color: var(--color-30);">
                    <i class="bi bi-type me-1" style="color: var(--color-10);"></i> Judul Buku <span class="text-danger">*</span>
                </label>
                <input type="text" 
                       name="title" 
                       class="form-control @error('title') is-invalid @enderror" 
                       placeholder="Masukkan judul buku" 
                       value="{{ old('title', $book->title) }}">
                @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold" style="color: var(--color-30);">
                    <i class="bi bi-pencil me-1" style="color: var(--color-10);"></i> Penulis <span class="text-danger">*</span>
                </label>
                <input type="text" 
                       name="author" 
                       class="form-control @error('author') is-invalid @enderror"
                       placeholder="Nama penulis" 
                       value="{{ old('author', $book->author) }}">
                @error('author')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold" style="color: var(--color-30);">
                    <i class="bi bi-upc-scan me-1" style="color: var(--color-10);"></i> ISBN
                </label>
                <input type="text" 
                       name="isbn" 
                       class="form-control @error('isbn') is-invalid @enderror"
                       placeholder="ISBN (opsional)" 
                       value="{{ old('isbn', $book->isbn) }}">
                @error('isbn')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold" style="color: var(--color-30);">
                    <i class="bi bi-building me-1" style="color: var(--color-10);"></i> Penerbit
                </label>
                <input type="text" 
                       name="publisher" 
                       class="form-control @error('publisher') is-invalid @enderror"
                       placeholder="Nama penerbit" 
                       value="{{ old('publisher', $book->publisher) }}">
                @error('publisher')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold" style="color: var(--color-30);">
                    <i class="bi bi-calendar me-1" style="color: var(--color-10);"></i> Tahun Terbit
                </label>
                <input type="number" 
                       name="publication_year" 
                       class="form-control @error('publication_year') is-invalid @enderror"
                       placeholder="Contoh: 2024" 
                       min="1900" 
                       max="{{ date('Y') }}"
                       value="{{ old('publication_year', $book->publication_year) }}">
                @error('publication_year')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Tahun antara 1900 - {{ date('Y') }}</small>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold" style="color: var(--color-30);">
                    <i class="bi bi-box me-1" style="color: var(--color-10);"></i> Stok <span class="text-danger">*</span>
                </label>
                <input type="number" 
                       name="stock" 
                       class="form-control @error('stock') is-invalid @enderror"
                       placeholder="Jumlah stok" 
                       min="0"
                       value="{{ old('stock', $book->stock) }}">
                @error('stock')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-12">
                <label class="form-label fw-semibold" style="color: var(--color-30);">
                    <i class="bi bi-file-text me-1" style="color: var(--color-10);"></i> Deskripsi
                </label>
                <textarea name="description" 
                          rows="4" 
                          class="form-control @error('description') is-invalid @enderror"
                          placeholder="Deskripsi singkat tentang buku">{{ old('description', $book->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <hr class="my-4" style="border-color: var(--border-light);">

        <div class="d-flex justify-content-end gap-3">
            <a href="{{ route('admin.books.index') }}" class="btn-outline-glass">
                <i class="bi bi-x-circle me-2"></i>Batal
            </a>
            <button type="submit" class="btn-primary-glass">
                <i class="bi bi-save me-2"></i>Update Buku
            </button>
        </div>
    </form>
</div>

{{-- Info Card --}}
<div class="row mt-4">
    <div class="col-12">
        <div class="glass-card p-3" style="background: rgba(212, 163, 115, 0.05);">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-info-circle-fill fs-4" style="color: var(--color-10);"></i>
                <div>
                    <small class="text-muted">Informasi</small>
                    <p class="mb-0 small text-dark">Buku yang sudah pernah dipinjam tidak dapat dihapus. Update stok dengan hati-hati.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control {
        border-radius: 13px;
        border: 1px solid var(--border-light);
        padding: 0.5rem 1rem;
        background: white;
    }
    
    .form-control:focus {
        border-color: var(--color-10);
        box-shadow: 0 0 0 0.2rem rgba(212, 163, 115, 0.25);
    }
    
    .form-control::placeholder {
        color: #adb5bd;
    }
    
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button {
        opacity: 0.5;
    }
</style>
@endsection