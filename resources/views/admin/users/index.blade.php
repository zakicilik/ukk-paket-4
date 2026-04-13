{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Data Anggota')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h3 class="fw-bold mb-1" style="color: var(--color-30);">
            <i class="bi bi-people-fill me-2" style="color: var(--color-10);"></i>Data Anggota Perpustakaan
        </h3>
        <p class="text-muted mb-0 small">Kelola seluruh data anggota perpustakaan digital</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn-primary-glass">
        <i class="bi bi-plus-circle me-2"></i>Tambah Anggota Baru
    </a>
</div>

<div class="card-table">
    <div class="table-responsive">
        <table class="table-custom">
            <thead>
                <tr>
                    <th style="width: 5%;">NO</th>
                    <th>NAMA LENGKAP</th>
                    <th>EMAIL</th>
                    <th>ROLE</th>
                    <th>TERDAFTAR</th>
                    <th style="width: 15%;" class="text-center">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $index => $u)
                <tr>
                    <td class="fw-semibold">{{ $loop->iteration }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background: rgba(212, 163, 115, 0.15);">
                                <i class="bi bi-person-circle" style="color: var(--color-10); font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <strong class="text-dark">{{ $u->name }}</strong><br>
                                <small class="text-muted">
                                    <i class="bi bi-person-badge me-1"></i>
                                    ID: {{ $u->id }}
                                </small>
                            </div>
                        </div>
                     </td>
                    <td>
                        <span class="text-dark">
                            <i class="bi bi-envelope me-1" style="color: var(--color-10);"></i>
                            {{ $u->email }}
                        </span>
                     </td>
                    <td>
                        @if($u->role == 'admin')
                            <span class="badge-danger">
                                <i class="bi bi-shield-lock me-1"></i> Admin
                            </span>
                        @else
                            <span class="badge-success">
                                <i class="bi bi-person me-1"></i> Anggota
                            </span>
                        @endif
                     </td>
                    <td>
                        <small class="text-muted">
                            <i class="bi bi-calendar me-1" style="color: var(--color-10);"></i>
                            {{ \Carbon\Carbon::parse($u->created_at)->translatedFormat('d F Y') }}
                        </small>
                     </td>
                    <td class="text-center">
                        <div class="btn-group" role="group" style="gap: 6px; justify-content: center;">
                            <a href="{{ route('admin.users.edit', $u->id) }}" 
                               class="btn-outline-glass" style="padding: 0.35rem 0.85rem; background: rgba(212, 163, 115, 0.1); border-color: var(--color-10); color: var(--color-10-dark);">
                                <i class="bi bi-pencil-square me-1"></i> Edit
                            </a>

                            <form action="{{ route('admin.users.destroy', $u->id) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota {{ addslashes($u->name) }}?')"
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
                    <td colspan="6" class="text-center py-5">
                        <div class="empty-state py-4">
                            <div class="empty-icon-box mx-auto mb-3">
                                <i class="bi bi-people fs-1"></i>
                            </div>
                            <h5 class="fw-semibold mb-2" style="color: var(--color-30);">Belum Ada Data Anggota</h5>
                            <p class="text-muted mb-3 small">Data anggota masih kosong. Silakan tambah anggota baru melalui tombol di atas.</p>
                            <span class="badge" style="background: rgba(212, 163, 115, 0.15); color: var(--color-10-dark); padding: 0.5rem 1rem; border-radius: 30px;">
                                <i class="bi bi-database-slash me-1"></i> 0 Anggota Tersimpan
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
@if(method_exists($users, 'links') && $users->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $users->links() }}
    </div>
@endif

{{-- Statistik Ringkas (Tanpa Admin) --}}
@php
    $totalAnggota = $users->count();
    $totalUser = $users->where('role', 'user')->count();
    $newMember = $users->where('created_at', '>=', now()->subDays(30))->count();
@endphp

<div class="row mt-4 g-4">
    <div class="col-md-4 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted text-uppercase">Total Anggota</small>
                    <h2 class="fw-bold mb-0 mt-2" style="color: var(--color-30); font-size: 2.618rem;">{{ $totalAnggota }}</h2>
                </div>
                <div class="rounded-3 p-3" style="background: rgba(212, 163, 115, 0.15);">
                    <i class="bi bi-people-fill fs-2" style="color: var(--color-10);"></i>
                </div>
            </div>
        </div>
    </div>
   
    <div class="col-md-4 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted text-uppercase">Anggota Aktif</small>
                    <h2 class="fw-bold mb-0 mt-2" style="color: var(--color-30); font-size: 2.618rem;">{{ $totalUser }}</h2>
                </div>
                <div class="rounded-3 p-3" style="background: rgba(212, 163, 115, 0.15);">
                    <i class="bi bi-person-check fs-2" style="color: var(--color-10);"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-sm-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <small class="text-muted text-uppercase">Member Baru</small>
                    <h2 class="fw-bold mb-0 mt-2" style="color: var(--color-10); font-size: 2.618rem;">{{ $newMember }}</h2>
                </div>
                <div class="rounded-3 p-3" style="background: rgba(212, 163, 115, 0.15);">
                    <i class="bi bi-person-plus fs-2" style="color: var(--color-10);"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection