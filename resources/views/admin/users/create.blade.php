{{-- resources/views/admin/users/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tambah Anggota')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h3 class="fw-bold mb-1" style="color: var(--color-30);">
            <i class="bi bi-person-plus-fill me-2" style="color: var(--color-10);"></i>Tambah Anggota Baru
        </h3>
        <p class="text-muted mb-0 small">Isi formulir berikut untuk menambahkan anggota baru ke perpustakaan</p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn-outline-glass">
        <i class="bi bi-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="glass-card p-4">
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label fw-semibold" style="color: var(--color-30);">
                    <i class="bi bi-person me-1" style="color: var(--color-10);"></i> Nama Lengkap <span class="text-danger">*</span>
                </label>
                <input type="text"
                    name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    placeholder="Masukkan nama lengkap"
                    value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Contoh: Ahmad Fauzi</small>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold" style="color: var(--color-30);">
                    <i class="bi bi-envelope me-1" style="color: var(--color-10);"></i> Email <span class="text-danger">*</span>
                </label>
                <input type="email"
                    name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    placeholder="Masukkan alamat email"
                    value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Contoh: ahmad@example.com</small>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold" style="color: var(--color-30);">
                    <i class="bi bi-lock me-1" style="color: var(--color-10);"></i> Password <span class="text-danger">*</span>
                </label>
                <input type="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    placeholder="Minimal 8 karakter">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Password minimal 8 karakter</small>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold" style="color: var(--color-30);">
                    <i class="bi bi-lock-fill me-1" style="color: var(--color-10);"></i> Konfirmasi Password <span class="text-danger">*</span>
                </label>
                <input type="password"
                    name="password_confirmation"
                    class="form-control"
                    placeholder="Ulangi password">
                <small class="text-muted">Ketik ulang password yang sama</small>
            </div>

            <div class="col-md-12">
                <label class="form-label fw-semibold" style="color: var(--color-30);">
                    <i class="bi bi-shield-lock me-1" style="color: var(--color-10);"></i> Role
                </label>
                <select name="role" class="form-select @error('role') is-invalid @enderror">
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Anggota</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Role "Admin" memiliki akses ke semua fitur</small>
            </div>
        </div>

        <hr class="my-4" style="border-color: var(--border-light);">

        <div class="d-flex justify-content-end gap-3">
            <a href="{{ route('admin.users.index') }}" class="btn-outline-glass">
                <i class="bi bi-x-circle me-2"></i>Batal
            </a>
            <button type="submit" class="btn-primary-glass">
                <i class="bi bi-save me-2"></i>Simpan Anggota
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
                    <small class="text-muted">Informasi Penting</small>
                    <p class="mb-0 small text-dark">
                        <i class="bi bi-check-circle text-success me-1"></i> Email harus unik dan belum terdaftar<br>
                        <i class="bi bi-check-circle text-success me-1"></i> Password minimal 8 karakter<br>
                        <i class="bi bi-check-circle text-success me-1"></i> Role "Admin" memiliki akses ke semua fitur
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control, .form-select {
        border-radius: 13px;
        border: 1px solid var(--border-light);
        padding: 0.5rem 1rem;
        background: white;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: var(--color-10);
        box-shadow: 0 0 0 0.2rem rgba(212, 163, 115, 0.25);
    }
    
    .form-control::placeholder {
        color: #adb5bd;
    }
    
    label {
        margin-bottom: 0.5rem;
    }
    
    .text-danger {
        font-size: 0.75rem;
    }
</style>

<script>
    // Password strength indicator
    const passwordInput = document.querySelector('input[name="password"]');
    const confirmInput = document.querySelector('input[name="password_confirmation"]');

    if (passwordInput && confirmInput) {
        function checkPasswordMatch() {
            if (passwordInput.value !== confirmInput.value && confirmInput.value !== '') {
                confirmInput.setCustomValidity('Password tidak cocok');
                confirmInput.style.borderColor = '#dc3545';
            } else {
                confirmInput.setCustomValidity('');
                confirmInput.style.borderColor = 'var(--border-light)';
            }
        }

        passwordInput.addEventListener('change', checkPasswordMatch);
        confirmInput.addEventListener('keyup', checkPasswordMatch);
    }
</script>
@endsection