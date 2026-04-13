<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; }
        .sidebar { height: 100vh; background: #343a40; color: white; }
        .sidebar a { color: white; display: block; padding: 12px; text-decoration: none; }
        .sidebar a:hover { background: #495057; }
        .card { border-radius: 15px; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        @if(Auth::check())
        <div class="col-md-2 sidebar">
            <h4 class="p-3">📚 Perpus</h4>
            @if(auth()->user()->role === 'admin')
                <a href="/admin"><i class="bi bi-speedometer2"></i> Dashboard</a>
                <a href="/books"><i class="bi bi-book"></i> Buku</a>
                <a href="/users"><i class="bi bi-people"></i> Anggota</a>
                <a href="/borrowings"><i class="bi bi-arrow-left-right"></i> Transaksi</a>
            @else
                <a href="/user"><i class="bi bi-house"></i> Dashboard</a>
                <a href="/transaksi"><i class="bi bi-bookmark"></i> Transaksi</a>
            @endif
            <a href="/logout" class="text-danger"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>
        @endif
        <div class="{{ Auth::check() ? 'col-md-10' : 'col-md-12' }} p-4">
            @yield('content')
        </div>
    </div>
</div>
</body>
</html>