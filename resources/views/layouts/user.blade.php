{{-- resources/views/layouts/user.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Perpustakaan Digital')</title>

    <!-- Bootstrap 5 + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            /* Warna dengan aturan 60-30-10 */
            --color-60: #F5F0E8;  /* 60% - Warna netral krem hangat (background utama) */
            --color-30: #2C3E50;  /* 30% - Warna navy gelap (sidebar, navbar) */
            --color-10: #D4A373;  /* 10% - Warna aksen terracotta/gold (tombol, aksen) */
            
            /* Warna pendukung */
            --color-10-light: #E6C9A8;
            --color-10-dark: #C28A5A;
            --color-30-light: #3D5166;
            --color-30-dark: #1A2A3A;
            --text-light: #F5F0E8;
            --text-dark: #2C3E50;
            --text-muted: #6B7280;
            
            /* Shadow & Border */
            --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            --card-shadow-hover: 0 8px 24px rgba(0, 0, 0, 0.12);
            --border-light: rgba(44, 62, 80, 0.1);
            --hover-bg: rgba(44, 62, 80, 0.05);
        }

        body {
            background: var(--color-60);
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            min-height: 100vh;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* ========= GOLDEN RATIO (1.618) ========= */
        /* Sidebar width: main content width = 1:1.618 */
        /* Sidebar: 280px, Main: ~453px (1.618x) -> tapi disesuaikan responsive */
        
        .sidebar {
            background: var(--color-30);
            border-right: none;
            height: 100vh;
            position: fixed;
            width: 280px;
            box-shadow: var(--card-shadow);
            z-index: 1050;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }

        .main-area {
            margin-left: 280px;
            padding: 1.5rem 2rem 2rem 2rem;
            min-height: 100vh;
        }
        
        /* Proporsi golden ratio untuk card dan komponen */
        .golden-card {
            border-radius: 21px; /* 13 x 1.618 ≈ 21 */
        }
        
        .golden-btn {
            border-radius: 13px;
            padding: 0.5rem 1.618rem;
        }

        .sidebar-header {
            padding: 2rem 1.8rem 1.5rem;
            border-bottom: 1px solid rgba(245, 240, 232, 0.15);
            margin-bottom: 1.2rem;
        }

        .logo-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            font-size: 2.2rem;
            background: linear-gradient(135deg, #D4A373, #E6C9A8);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .sidebar-header h3 {
            font-weight: 800;
            font-size: 1.7rem;
            letter-spacing: -0.5px;
            background: linear-gradient(120deg, #D4A373, #E6C9A8);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin: 0;
        }

        .sidebar-sub {
            font-size: 0.7rem;
            color: rgba(245, 240, 232, 0.6);
            letter-spacing: 0.3px;
            margin-top: 6px;
        }

        .nav-link {
            padding: 12px 24px;
            margin: 4px 16px;
            border-radius: 13px;
            color: rgba(245, 240, 232, 0.8);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 14px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
            text-decoration: none;
        }

        .nav-link i {
            font-size: 1.35rem;
            width: 28px;
        }

        .nav-link:hover {
            background: rgba(245, 240, 232, 0.1);
            color: var(--color-10);
            transform: translateX(5px);
        }

        .nav-link.active {
            background: rgba(212, 163, 115, 0.15);
            color: var(--color-10);
            border-left: 3px solid var(--color-10);
            transform: translateX(0);
        }

        .user-profile {
            background: rgba(245, 240, 232, 0.08);
            border-radius: 21px;
            padding: 14px 12px;
            margin: 0 16px 20px 16px;
            border: 1px solid rgba(245, 240, 232, 0.1);
        }

        /* TOPBAR */
        .topbar {
            background: white;
            border-radius: 21px;
            padding: 1rem 2rem;
            box-shadow: var(--card-shadow);
            margin-bottom: 2rem;
            border: 1px solid var(--border-light);
        }

        .date-chip {
            background: var(--color-60);
            border-radius: 40px;
            padding: 0.45rem 1.2rem;
            font-weight: 500;
            font-size: 0.8rem;
            color: var(--text-dark);
            border: 1px solid var(--border-light);
        }

        /* ========= CARD STYLES ========= */
        .glass-card {
            background: white;
            border-radius: 21px;
            border: 1px solid var(--border-light);
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--card-shadow-hover);
        }

        .stat-card {
            background: white;
            border-radius: 21px;
            border: 1px solid var(--border-light);
            padding: 1.3rem;
            transition: all 0.3s ease;
            box-shadow: var(--card-shadow);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--card-shadow-hover);
        }

        /* ========= TABLE STYLES ========= */
        .glass-table-container {
            background: white;
            border-radius: 21px;
            border: 1px solid var(--border-light);
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }

        .premium-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        .premium-table thead tr {
            background: var(--color-60);
            border-bottom: 1px solid var(--border-light);
        }

        .premium-table thead th {
            padding: 1rem 1.2rem;
            font-weight: 700;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: var(--text-dark);
        }

        .premium-table tbody td {
            padding: 1rem 1.2rem;
            color: var(--text-dark);
            border-bottom: 1px solid var(--border-light);
        }

        .premium-table tbody tr {
            transition: all 0.2s;
        }

        .premium-table tbody tr:hover {
            background: var(--color-60);
        }

        /* ========= BUTTON STYLES ========= */
        .btn-primary-glass {
            background: linear-gradient(135deg, var(--color-10), var(--color-10-dark));
            border: none;
            border-radius: 13px;
            padding: 0.5rem 1.618rem;
            font-weight: 600;
            transition: all 0.3s ease;
            color: white;
        }

        .btn-primary-glass:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(212, 163, 115, 0.4);
            color: white;
            background: linear-gradient(135deg, var(--color-10-dark), var(--color-10));
        }

        .btn-outline-glass {
            background: transparent;
            border: 1px solid var(--border-light);
            border-radius: 13px;
            padding: 0.4rem 1rem;
            font-size: 0.85rem;
            color: var(--text-dark);
            transition: 0.2s;
        }

        .btn-outline-glass:hover {
            background: var(--hover-bg);
            border-color: var(--color-10);
            color: var(--color-10);
        }

        /* ========= BADGE STYLES ========= */
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

        .badge-info {
            background: #E0F2FE;
            color: #075985;
            padding: 0.35rem 0.85rem;
            border-radius: 30px;
            font-weight: 500;
        }

        .badge-primary {
            background: rgba(212, 163, 115, 0.15);
            color: var(--color-10-dark);
            padding: 0.35rem 0.85rem;
            border-radius: 30px;
            font-weight: 500;
        }

        /* ========= LOADING ========= */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(245, 240, 232, 0.95);
            backdrop-filter: blur(8px);
            z-index: 2000;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: 0.2s;
        }

        .spinner-custom {
            width: 55px;
            height: 55px;
            border: 3px solid rgba(44, 62, 80, 0.2);
            border-top: 3px solid var(--color-10);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* ========= ALERT ========= */
        .alert-glass {
            border-radius: 16px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            border: none;
        }

        .alert-success-custom {
            background: #D1FAE5;
            color: #065F46;
            border-radius: 13px;
        }

        .alert-danger-custom {
            background: #FEE2E2;
            color: #991B1B;
            border-radius: 13px;
        }

        /* ========= EMPTY STATE ========= */
        .empty-state {
            text-align: center;
            padding: 3rem 1.5rem;
        }

        .empty-icon-box {
            width: 80px;
            height: 80px;
            background: var(--color-60);
            border-radius: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.2rem;
        }

        .empty-icon-box i {
            font-size: 2.5rem;
            color: var(--color-30-light);
        }

        /* ========= RESPONSIVE ========= */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 280px;
                position: fixed;
                z-index: 1060;
            }
            .sidebar.show {
                transform: translateX(0);
            }
            .main-area {
                margin-left: 0;
                padding: 1rem;
            }
            .menu-toggle {
                display: block;
                position: fixed;
                top: 1rem;
                left: 1rem;
                z-index: 1070;
                background: white;
                border: 1px solid var(--border-light);
                border-radius: 13px;
                padding: 0.5rem 0.75rem;
                color: var(--text-dark);
                box-shadow: var(--card-shadow);
            }
        }
        
        @media (min-width: 769px) {
            .menu-toggle {
                display: none;
            }
        }

        /* ========= SCROLLBAR ========= */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: var(--color-60);
        }
        ::-webkit-scrollbar-thumb {
            background: var(--color-10-light);
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--color-10);
        }

        /* ========= ANIMATIONS ========= */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.3s ease;
        }
        
        /* Golden ratio typography */
        h1 { font-size: 2.618rem; }
        h2 { font-size: 1.618rem; }
        h3 { font-size: 1.382rem; }
        p { line-height: 1.618; }
    </style>
</head>
<body>

<!-- Mobile Menu Toggle Button -->
<button class="menu-toggle" id="menuToggle">
    <i class="bi bi-list fs-4"></i>
</button>

<!-- SIDEBAR - 30% warna dominan -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo-wrapper">
            <i class="bi bi-stack logo-icon"></i>
            <h3>Libra<span style="color: var(--color-10);">Core</span></h3>
        </div>
        <div class="sidebar-sub">Perpustakaan Digital • Member</div>
    </div>

    <div class="nav flex-column">
        <a href="{{ route('user.dashboard') }}" class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-door-fill"></i> Beranda
        </a>
        <a href="{{ route('user.books') }}" class="nav-link {{ request()->routeIs('user.books') ? 'active' : '' }}">
            <i class="bi bi-book-half"></i> Jelajahi Buku
        </a>
        <a href="{{ route('user.borrowings') }}" class="nav-link {{ request()->routeIs('user.borrowings') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i> Riwayat Peminjaman
        </a>
    </div>

    <div class="position-absolute bottom-0 w-100 p-3 pb-4">
        <div class="user-profile">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <i class="bi bi-person-circle me-2" style="color: var(--color-10);"></i>
                    <span class="fw-semibold text-light">{{ auth()->user()->name ?? 'Member' }}</span>
                    <div class="small text-light opacity-75">{{ auth()->user()->email ?? 'member@perpus.id' }}</div>
                </div>
                <span class="badge-primary px-3 py-1" style="font-size: 0.65rem;">MEMBER</span>
            </div>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link text-danger mt-2">
            <i class="bi bi-box-arrow-right"></i> Keluar
        </a>
    </div>
</div>

<!-- MAIN CONTENT - 60% warna background -->
<div class="main-area">
    <div class="topbar d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div class="d-flex align-items-center gap-3">
            <i class="bi bi-grid-3x3-gap-fill fs-3" style="color: var(--color-10);"></i>
            <h4 class="fw-bold mb-0">@yield('title', 'Dashboard Member')</h4>
        </div>
        <div class="date-chip">
            <i class="bi bi-calendar-week me-1"></i> 
            <span>{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</span>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert alert-success-custom alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger-custom alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="text-center">
        <div class="spinner-custom mx-auto"></div>
        <p class="mt-3 fw-medium text-secondary">Memuat halaman...</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Hilangkan loading overlay setelah halaman siap
    window.addEventListener('load', () => {
        setTimeout(() => {
            const loading = document.getElementById('loadingOverlay');
            if (loading) loading.style.display = 'none';
        }, 500);
    });

    // Efek loading saat klik link sidebar
    document.querySelectorAll('.sidebar .nav-link').forEach(link => {
        link.addEventListener('click', function(e) {
            if (this.getAttribute('href') !== '#' && this.getAttribute('href') !== '') {
                const loading = document.getElementById('loadingOverlay');
                if (loading) loading.style.display = 'flex';
            }
        });
    });
    
    // Mobile menu toggle
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    
    if (menuToggle) {
        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('show');
        });
    }
    
    // Auto close alerts after 5 seconds
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                if (alert) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            }, 4500);
        });
    }, 1000);
</script>
</body>
</html>