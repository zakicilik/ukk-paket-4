{{-- resources/views/admin/users/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Anggota')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h3 class="fw-bold mb-1" style="color: var(--color-30);">
            <i class="bi bi-pencil-square me-2" style="color: var(--color-10);"></i>Edit Data Anggota
        </h3>
        <p class="text-muted mb-0 small">Perbarui informasi anggota perpustakaan</p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn-outline-glass">
        <i class="bi bi-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="glass-card">
    <div class="card-body p-4">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Nama Lengkap --}}
            <div class="mb-4">
                <label class="form-label fw-semibold mb-2" style="color: var(--color-30);">
                    <i class="bi bi-person me-2" style="color: var(--color-10);"></i>
                    Nama Lengkap <span class="text-danger">*</span>
                </label>
                <input type="text"
                    name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    placeholder="Masukkan nama lengkap"
                    value="{{ old('name', $user->name) }}"
                    style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #e5e7eb;">
                @error('name')
                    <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror
                <small class="text-muted mt-1 d-block">Contoh: Ahmad Fauzi</small>
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label class="form-label fw-semibold mb-2" style="color: var(--color-30);">
                    <i class="bi bi-envelope me-2" style="color: var(--color-10);"></i>
                    Email <span class="text-danger">*</span>
                </label>
                <input type="email"
                    name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    placeholder="Masukkan alamat email"
                    value="{{ old('email', $user->email) }}"
                    style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #e5e7eb;">
                @error('email')
                    <div class="text-danger mt-1 small">{{ $message }}</div>
                @enderror
                <small class="text-muted mt-1 d-block">Contoh: ahmad@example.com</small>
            </div>

            {{-- Password dan Konfirmasi dalam 2 kolom --}}
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold mb-2" style="color: var(--color-30);">
                        <i class="bi bi-lock me-2" style="color: var(--color-10);"></i>
                        Password <span class="text-muted">(opsional)</span>
                    </label>
                    <input type="password"
                        name="password"
                        id="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Kosongkan jika tidak ingin mengubah"
                        style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #e5e7eb;">
                    @error('password')
                        <div class="text-danger mt-1 small">{{ $message }}</div>
                    @enderror
                    <small class="text-muted mt-1 d-block">Minimal 8 karakter, kosongkan jika tidak ingin mengubah</small>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold mb-2" style="color: var(--color-30);">
                        <i class="bi bi-lock-fill me-2" style="color: var(--color-10);"></i>
                        Konfirmasi Password
                    </label>
                    <input type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        class="form-control"
                        placeholder="Ulangi password baru"
                        style="width: 100%; padding: 12px 15px; border-radius: 12px; border: 1px solid #e5e7eb;">
                    <small class="text-muted mt-1 d-block">Ketik ulang password baru jika diubah</small>
                </div>
            </div>

            <hr class="my-4" style="border-color: #e5e7eb;">

            <div class="d-flex justify-content-end gap-3">
                <a href="{{ route('admin.users.index') }}" class="btn-outline-glass" style="padding: 10px 25px;">
                    <i class="bi bi-x-circle me-2"></i>Batal
                </a>
                <button type="submit" class="btn-primary-glass" style="padding: 10px 30px;">
                    <i class="bi bi-save me-2"></i>Update Anggota
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Info Card --}}
<div class="row mt-4">
    <div class="col-12">
        <div class="glass-card p-3" style="background: rgba(212, 163, 115, 0.05);">
            <div class="d-flex align-items-center gap-3">
                <i class="bi bi-info-circle-fill fs-4" style="color: var(--color-10);"></i>
                <div>
                    <small class="text-muted">Informasi Penting</small>
                    <p class="mb-0 small text-dark">
                        <i class="bi bi-check-circle text-success me-1"></i> Email harus unik dan belum terdaftar oleh anggota lain<br>
                        <i class="bi bi-check-circle text-success me-1"></i> Kosongkan password jika tidak ingin mengubahnya
                    </p>
                </div>
            </div>
        </div>
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
    
    .btn-outline-glass {
        background: transparent;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 0.4rem 1rem;
        font-size: 0.85rem;
        color: #2C3E50;
        transition: 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .btn-outline-glass:hover {
        background: #f5f0e8;
        transform: translateY(-1px);
    }
    
    .btn-primary-glass {
        background: linear-gradient(135deg, #D4A373, #C28A5A);
        border: none;
        border-radius: 12px;
        padding: 0.5rem 1rem;
        font-weight: 600;
        transition: all 0.3s ease;
        color: white;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .btn-primary-glass:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(212, 163, 115, 0.3);
    }
    
    .text-muted {
        color: #8b8580 !important;
        font-size: 0.7rem;
    }
</style>

<script>
    // Password match validation
    const passwordInput = document.querySelector('#password');
    const confirmInput = document.querySelector('#password_confirmation');

    if (passwordInput && confirmInput) {
        function checkPasswordMatch() {
            if (passwordInput.value !== confirmInput.value && confirmInput.value !== '') {
                confirmInput.setCustomValidity('Password tidak cocok');
                confirmInput.style.borderColor = '#dc3545';
            } else {
                confirmInput.setCustomValidity('');
                confirmInput.style.borderColor = '#e5e7eb';
            }
        }

        passwordInput.addEventListener('change', checkPasswordMatch);
        confirmInput.addEventListener('keyup', checkPasswordMatch);
    }
</script>
@endsection