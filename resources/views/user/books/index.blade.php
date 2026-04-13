{{-- resources/views/user/books/index.blade.php --}}
@extends('layouts.user')

@section('title', 'Jelajahi Buku')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h4 class="fw-bold mb-1" style="color: var(--color-30);">
            <i class="bi bi-book-half me-2" style="color: var(--color-10);"></i>Koleksi Buku
        </h4>
        <p class="text-muted mb-0 small">Jelajahi dan pinjam buku favorit Anda</p>
    </div>
    <div class="text-muted">
        <i class="bi bi-grid me-1"></i> 
        <span class="fw-semibold" id="totalBooks">{{ $books->total() }}</span> Buku tersedia
    </div>
</div>

{{-- FORM PENCARIAN --}}
<div class="glass-card mb-4 p-3">
    <div class="d-flex gap-2">
        <div class="flex-grow-1 position-relative">
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0" style="border-radius: 21px 0 0 21px;">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" 
                       id="searchInput"
                       class="form-control border-start-0" 
                       style="border-radius: 0 21px 21px 0;"
                       placeholder="Cari judul buku atau penulis..." 
                       value="{{ request('search') }}"
                       autocomplete="off">
            </div>
            <div id="searchLoading" class="position-absolute" style="right: 15px; top: 50%; transform: translateY(-50%); display: none;">
                <div class="spinner-border spinner-border-sm" role="status" style="color: var(--color-10);">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
        <button type="button" id="searchButton" class="btn-primary-glass">
            <i class="bi bi-search me-1"></i> Cari
        </button>
        @if(request('search'))
            <a href="{{ route('user.books') }}" id="resetButton" class="btn-outline-glass">
                <i class="bi bi-x-circle me-1"></i> Reset
            </a>
        @endif
    </div>
</div>

{{-- HASIL PENCARIAN --}}
<div id="searchInfo">
    @if(request('search'))
        <div class="alert-glass mb-4" style="background: rgba(212, 163, 115, 0.1); border-left: 4px solid var(--color-10);">
            <i class="bi bi-info-circle-fill me-2" style="color: var(--color-10);"></i>
            Menampilkan hasil pencarian untuk: <strong>"{{ request('search') }}"</strong>
            <span class="badge ms-2" style="background: var(--color-10); color: white; padding: 0.25rem 0.75rem; border-radius: 30px;">{{ $books->total() }} hasil</span>
        </div>
    @endif
</div>

{{-- LIST BUKU --}}
<div id="booksContainer">
    <div class="row g-4" id="booksList">
        @forelse($books as $book)
        <div class="col-md-6 col-lg-4 book-item">
            <div class="glass-card h-100 p-4">
                <div class="d-flex align-items-start gap-3 mb-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 55px; height: 55px; background: rgba(212, 163, 115, 0.15); flex-shrink: 0;">
                        <i class="bi bi-book fs-2" style="color: var(--color-10);"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="fw-bold mb-1" style="color: var(--color-30);">{{ Str::limit($book->title, 35) }}</h5>
                        <p class="text-muted small mb-0">
                            <i class="bi bi-pencil me-1"></i> {{ $book->author }}
                        </p>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small"><i class="bi bi-building me-1"></i> Penerbit</span>
                        <span class="small fw-semibold text-dark">{{ $book->publisher ?? '-' }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small"><i class="bi bi-calendar me-1"></i> Tahun</span>
                        <span class="small fw-semibold text-dark">{{ $book->publication_year ?? '-' }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted small"><i class="bi bi-upc-scan me-1"></i> ISBN</span>
                        <span class="small fw-semibold text-dark">{{ $book->isbn ?? '-' }}</span>
                    </div>
                </div>

                <hr class="my-3" style="border-color: var(--border-light, rgba(44, 62, 80, 0.1));">
                
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        @if($book->stock > 0)
                            <span class="badge-success">
                                <i class="bi bi-check-circle me-1"></i> Tersedia: {{ $book->stock }}
                            </span>
                        @else
                            <span class="badge" style="background: #FEE2E2; color: #991B1B; padding: 0.35rem 0.85rem; border-radius: 30px; font-weight: 500;">
                                <i class="bi bi-x-circle me-1"></i> Habis
                            </span>
                        @endif
                    </div>
                    
                    @php
                        $dipinjam = $borrowings->where('book_id', $book->id)
                            ->whereIn('status', ['dipinjam', 'menunggu'])->count();
                    @endphp

                    @if($book->stock > 0 && $dipinjam == 0)
                        <form action="{{ route('user.pinjam', $book->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn-primary-glass" style="padding: 0.4rem 1rem; font-size: 0.85rem;" onclick="return confirm('Yakin ingin meminjam buku {{ addslashes($book->title) }}?')">
                                <i class="bi bi-cart-plus me-1"></i> Pinjam
                            </button>
                        </form>
                    @elseif($dipinjam > 0)
                        <span class="badge-warning">
                            <i class="bi bi-clock-history me-1"></i> Sedang Dipinjam
                        </span>
                    @else
                        <span class="badge" style="background: #F3F4F6; color: #6B7280; padding: 0.35rem 0.85rem; border-radius: 30px; font-weight: 500;">
                            <i class="bi bi-x-octagon me-1"></i> Tidak Tersedia
                        </span>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="glass-card">
                <div class="card-body py-5 text-center">
                    <div class="empty-icon-box mx-auto mb-3">
                        <i class="bi bi-journal-bookmark-fill fs-1"></i>
                    </div>
                    <h5 class="fw-semibold mb-2" style="color: var(--color-30);">
                        @if(request('search'))
                            Tidak ada buku yang ditemukan
                        @else
                            Belum Ada Buku
                        @endif
                    </h5>
                    <p class="text-muted mb-0">
                        @if(request('search'))
                            Tidak ada buku dengan kata kunci "<strong>{{ request('search') }}</strong>"
                        @else
                            Koleksi buku masih kosong. Silakan cek kembali nanti.
                        @endif
                    </p>
                    @if(request('search'))
                        <a href="{{ route('user.books') }}" class="btn-outline-glass mt-3 d-inline-block">
                            <i class="bi bi-arrow-left me-1"></i> Lihat Semua Buku
                        </a>
                    @endif
                </div>
            </div>
        </div>
        @endforelse
    </div>
</div>

{{-- Pagination --}}
@if($books->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $books->links() }}
    </div>
@endif

<style>
    :root {
        --color-60: #F5F0E8;
        --color-30: #2C3E50;
        --color-30-dark: #1A2A3A;
        --color-30-light: #3D5166;
        --color-10: #D4A373;
        --color-10-dark: #C28A5A;
        --color-10-light: #E6C9A8;
        --border-light: rgba(44, 62, 80, 0.1);
        --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        --card-shadow-hover: 0 8px 24px rgba(0, 0, 0, 0.12);
    }
    
    /* Golden Ratio untuk card */
    .glass-card {
        background: white;
        border-radius: 21px;
        border: 1px solid var(--border-light);
        box-shadow: var(--card-shadow);
        transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
    }
    
    .glass-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-shadow-hover);
    }
    
    /* Golden Ratio untuk input */
    .input-group .input-group-text,
    .input-group .form-control {
        border-radius: 21px !important;
    }
    
    .input-group .input-group-text {
        border-right: none;
        background-color: white;
    }
    
    .input-group .form-control:focus {
        box-shadow: none;
        border-color: var(--color-10);
    }
    
    .input-group:focus-within {
        box-shadow: 0 0 0 0.2rem rgba(212, 163, 115, 0.25);
        border-radius: 21px;
    }
    
    .input-group:focus-within .input-group-text,
    .input-group:focus-within .form-control {
        border-color: var(--color-10);
    }
    
    /* Badge styles dari layout */
    .badge-success {
        background: #D1FAE5;
        color: #065F46;
        padding: 0.35rem 0.85rem;
        border-radius: 30px;
        font-weight: 500;
    }
    
    .badge-warning {
        background: #FEF3C7;
        color: #92400E;
        padding: 0.35rem 0.85rem;
        border-radius: 30px;
        font-weight: 500;
    }
    
    .empty-icon-box {
        width: 80px;
        height: 80px;
        background: #F3F4F6;
        border-radius: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.2rem;
    }
    
    .empty-icon-box i {
        font-size: 2.5rem;
        color: #9CA3AF;
    }
    
    /* Animasi golden ratio */
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
    
    .book-item {
        animation: fadeIn 0.4s ease forwards;
    }
    
    .book-item:nth-child(1) { animation-delay: 0.05s; }
    .book-item:nth-child(2) { animation-delay: 0.1s; }
    .book-item:nth-child(3) { animation-delay: 0.15s; }
    .book-item:nth-child(4) { animation-delay: 0.2s; }
    .book-item:nth-child(5) { animation-delay: 0.25s; }
    .book-item:nth-child(6) { animation-delay: 0.3s; }
    
    /* Responsive */
    @media (max-width: 768px) {
        .glass-card {
            border-radius: 16px;
        }
        
        .book-item {
            animation-delay: 0s !important;
        }
    }
</style>

<script>
    let searchTimeout;
    const searchInput = document.getElementById('searchInput');
    const searchButton = document.getElementById('searchButton');
    const searchLoading = document.getElementById('searchLoading');
    const booksContainer = document.getElementById('booksContainer');
    const totalBooksSpan = document.getElementById('totalBooks');
    const searchInfoDiv = document.getElementById('searchInfo');
    
    function performSearch() {
        const keyword = searchInput.value;
        
        if (searchLoading) searchLoading.style.display = 'block';
        
        fetch('{{ route("user.books") }}?search=' + encodeURIComponent(keyword))
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                const newBooksList = doc.querySelector('#booksList');
                const newTotal = doc.querySelector('#totalBooks');
                const newSearchInfo = doc.querySelector('#searchInfo');
                const newPagination = doc.querySelector('.pagination');
                
                if (newBooksList) {
                    document.getElementById('booksList').innerHTML = newBooksList.innerHTML;
                }
                if (newTotal && totalBooksSpan) {
                    totalBooksSpan.textContent = newTotal.textContent;
                }
                if (newSearchInfo && searchInfoDiv) {
                    searchInfoDiv.innerHTML = newSearchInfo.innerHTML;
                }
                if (newPagination) {
                    let oldPagination = document.querySelector('.pagination');
                    if (oldPagination) oldPagination.remove();
                    if (document.querySelector('.d-flex.justify-content-center.mt-4')) {
                        document.querySelector('.d-flex.justify-content-center.mt-4').remove();
                    }
                    const paginationContainer = document.createElement('div');
                    paginationContainer.className = 'd-flex justify-content-center mt-4';
                    paginationContainer.innerHTML = newPagination.outerHTML;
                    booksContainer.parentNode.appendChild(paginationContainer);
                }
                
                if (searchLoading) searchLoading.style.display = 'none';
                
                const url = new URL(window.location.href);
                if (keyword.trim() !== '') {
                    url.searchParams.set('search', keyword);
                } else {
                    url.searchParams.delete('search');
                }
                window.history.pushState({}, '', url);
                
                const resetBtn = document.getElementById('resetButton');
                if (keyword.trim() !== '' && !resetBtn) {
                    const btnContainer = document.querySelector('.d-flex.gap-2');
                    const resetLink = document.createElement('a');
                    resetLink.id = 'resetButton';
                    resetLink.href = '{{ route("user.books") }}';
                    resetLink.className = 'btn-outline-glass';
                    resetLink.innerHTML = '<i class="bi bi-x-circle me-1"></i> Reset';
                    btnContainer.appendChild(resetLink);
                } else if (keyword.trim() === '' && resetBtn) {
                    resetBtn.remove();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (searchLoading) searchLoading.style.display = 'none';
            });
    }
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            if (searchLoading) searchLoading.style.display = 'block';
            searchTimeout = setTimeout(performSearch, 500);
        });
    }
    
    if (searchButton) {
        searchButton.addEventListener('click', performSearch);
    }
    
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                performSearch();
            }
        });
    }
</script>
@endsection