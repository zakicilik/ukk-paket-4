{{-- resources/views/admin/books/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tambah Buku Baru')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h3 class="fw-bold mb-1" style="color: var(--color-30);">
            <i class="bi bi-plus-circle me-2" style="color: var(--color-10);"></i>Tambah Buku Baru
        </h3>
        <p class="text-muted mb-0 small">Masukkan informasi buku yang akan ditambahkan ke koleksi</p>
    </div>
    <a href="{{ route('admin.books.index') }}" class="btn-outline-glass">
        <i class="bi bi-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="glass-card">
    <div class="card-body p-4">
        <form action="{{ route('admin.books.store') }}" method="POST">
            @csrf

            {{-- Judul Buku --}}
            <div class="mb-4">
                <label class="form-label fw-semibold mb-2" style="color: var(--color-30);">
                    <i class="bi bi-type me-2" style="color: var(--color-10);"></i>
                    Judul Buku <span class="text-danger">*</span>
                </label>
                <input type="text" 
                       name="title" 
                       id="title"
                       class="form-control @error('title') is-invalid @enderror" 
                       placeholder="Masukkan judul buku" 
                       value="{{ old('title') }}" 
                       required
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #e5e7eb;">
                @error('title')
                    <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Penulis --}}
            <div class="mb-4">
                <label class="form-label fw-semibold mb-2" style="color: var(--color-30);">
                    <i class="bi bi-pencil me-2" style="color: var(--color-10);"></i>
                    Penulis <span class="text-danger">*</span>
                </label>
                <input type="text" 
                       name="author" 
                       id="author"
                       class="form-control @error('author') is-invalid @enderror"
                       placeholder="Nama penulis" 
                       value="{{ old('author') }}" 
                       required
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #e5e7eb;">
                @error('author')
                    <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror
            </div>

            {{-- ISBN dengan Generate --}}
            <div class="mb-4">
                <label class="form-label fw-semibold mb-2" style="color: var(--color-30);">
                    <i class="bi bi-upc-scan me-2" style="color: var(--color-10);"></i>
                    ISBN
                </label>
                <div class="d-flex gap-2">
                    <input type="text" 
                           name="isbn" 
                           id="isbn"
                           class="form-control @error('isbn') is-invalid @enderror"
                           placeholder="ISBN (otomatis atau manual)" 
                           value="{{ old('isbn') }}"
                           style="flex: 1; padding: 12px 15px; border-radius: 12px; border: 1px solid #e5e7eb;">
                    <button type="button" 
                            id="generateIsbnBtn"
                            style="background: rgba(212, 163, 115, 0.1); border: 1px solid #e5e7eb; border-radius: 12px; padding: 0 20px; color: #C28A5A; font-weight: 500;">
                        <i class="bi bi-magic"></i> Generate
                    </button>
                </div>
                @error('isbn')
                    <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror
                <small class="text-muted mt-1 d-block">
                    <i class="bi bi-info-circle"></i> Klik Generate untuk membuat ISBN otomatis
                </small>
            </div>

            {{-- Penerbit --}}
            <div class="mb-4">
                <label class="form-label fw-semibold mb-2" style="color: var(--color-30);">
                    <i class="bi bi-building me-2" style="color: var(--color-10);"></i>
                    Penerbit
                </label>
                <input type="text" 
                       name="publisher" 
                       class="form-control @error('publisher') is-invalid @enderror"
                       placeholder="Nama penerbit" 
                       value="{{ old('publisher') }}"
                       style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #e5e7eb;">
                @error('publisher')
                    <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror
            </div>

            {{-- Tahun Terbit dan Stok dalam 2 kolom --}}
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold mb-2" style="color: var(--color-30);">
                        <i class="bi bi-calendar me-2" style="color: var(--color-10);"></i>
                        Tahun Terbit
                    </label>
                    <input type="number" 
                           name="publication_year" 
                           class="form-control @error('publication_year') is-invalid @enderror"
                           placeholder="Contoh: 2024" 
                           min="1900" 
                           max="{{ date('Y') }}"
                           value="{{ old('publication_year') }}"
                           style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #e5e7eb;">
                    @error('publication_year')
                        <div class="text-danger mt-1 small">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">1900 - {{ date('Y') }}</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold mb-2" style="color: var(--color-30);">
                        <i class="bi bi-box me-2" style="color: var(--color-10);"></i>
                        Stok <span class="text-danger">*</span>
                    </label>
                    <input type="number" 
                           name="stock" 
                           class="form-control @error('stock') is-invalid @enderror"
                           placeholder="Jumlah stok" 
                           min="0" 
                           value="{{ old('stock', 1) }}" 
                           required
                           style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #e5e7eb;">
                    @error('stock')
                        <div class="text-danger mt-1 small">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="mb-4">
                <label class="form-label fw-semibold mb-2" style="color: var(--color-30);">
                    <i class="bi bi-file-text me-2" style="color: var(--color-10);"></i>
                    Deskripsi
                </label>
                <textarea name="description" 
                          rows="5" 
                          class="form-control @error('description') is-invalid @enderror"
                          placeholder="Deskripsi singkat tentang buku"
                          style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #e5e7eb; resize: vertical;">{{ old('description') }}</textarea>
                @error('description')
                    <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror
            </div>

            <hr class="my-4" style="border-color: #e5e7eb;">

            <div class="d-flex justify-content-end gap-3">
                <a href="{{ route('admin.books.index') }}" class="btn-outline-glass" style="padding: 10px 25px;">
                    <i class="bi bi-x-circle me-2"></i>Batal
                </a>
                <button type="submit" class="btn-primary-glass" style="padding: 10px 30px;">
                    <i class="bi bi-save me-2"></i>Simpan Buku
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .glass-card {
        background: white;
        border-radius: 24px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    
    .form-control:focus {
        border-color: #D4A373 !important;
        box-shadow: 0 0 0 3px rgba(212, 163, 115, 0.15) !important;
        outline: none;
    }
    
    .btn-outline-glass:hover {
        background: #f5f0e8;
        transform: translateY(-1px);
    }
    
    .btn-primary-glass:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(212, 163, 115, 0.3);
    }
    
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button {
        opacity: 0.5;
    }
</style>

<script>
    function generateISBN() {
        const title = document.getElementById('title');
        const author = document.getElementById('author');
        const isbnInput = document.getElementById('isbn');
        
        let isbn = '';
        
        if (!title.value && !author.value) {
            const prefix = '978';
            const random1 = Math.floor(Math.random() * 100).toString().padStart(2, '0');
            const random2 = Math.floor(Math.random() * 10000).toString().padStart(4, '0');
            const random3 = Math.floor(Math.random() * 100).toString().padStart(2, '0');
            const random4 = Math.floor(Math.random() * 10).toString();
            isbn = `${prefix}-${random1}-${random2}-${random3}-${random4}`;
        } else {
            let isbnBase = '978';
            if (title.value) {
                const titleCode = title.value.substring(0, 3).toUpperCase().split('').map(c => c.charCodeAt(0) % 10).join('');
                isbnBase += '-' + titleCode.padStart(3, '0');
            } else {
                isbnBase += '-001';
            }
            if (author.value) {
                const authorCode = author.value.substring(0, 2).toUpperCase().split('').map(c => c.charCodeAt(0) % 10).join('');
                isbnBase += '-' + authorCode.padStart(2, '0');
            } else {
                isbnBase += '-01';
            }
            const randomNum = Math.floor(Math.random() * 10000).toString().padStart(4, '0');
            const checkDigit = Math.floor(Math.random() * 10);
            isbn = `${isbnBase}-${randomNum}-${checkDigit}`;
        }
        
        isbnInput.value = isbn;
        isbnInput.style.borderColor = '#D4A373';
        setTimeout(() => {
            isbnInput.style.borderColor = '';
        }, 1000);
    }
    
    const generateBtn = document.getElementById('generateIsbnBtn');
    if (generateBtn) {
        generateBtn.addEventListener('click', generateISBN);
    }
    
    const titleInput = document.getElementById('title');
    const authorInput = document.getElementById('author');
    const isbnInput = document.getElementById('isbn');
    
    function autoGenerateIfEmpty() {
        if (!isbnInput.value && (titleInput.value || authorInput.value)) {
            generateISBN();
        }
    }
    
    if (titleInput && authorInput) {
        titleInput.addEventListener('blur', autoGenerateIfEmpty);
        authorInput.addEventListener('blur', autoGenerateIfEmpty);
    }
</script>
@endsection