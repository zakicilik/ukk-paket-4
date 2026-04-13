{{-- resources/views/auth/register.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register | Perpustakaan Digital</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --accent-blue: #4361EE;
            --accent-purple: #7B2CBF;
            --accent-gradient: linear-gradient(135deg, #4361EE, #7B2CBF);
            --text-primary: #1F2937;
            --text-secondary: #6B7280;
            --card-white: #FFFFFF;
            --border-light: #E5E7EB;
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
        }

        .register-card {
            background: var(--card-white);
            border-radius: 32px;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            max-width: 500px;
            width: 100%;
            animation: fadeInUp 0.5s ease;
        }

        .register-header {
            background: var(--accent-gradient);
            padding: 2rem;
            text-align: center;
            color: white;
        }

        .register-header .logo-icon {
            font-size: 3rem;
            margin-bottom: 0.5rem;
        }

        .register-header h2 {
            font-weight: 800;
            font-size: 1.8rem;
            margin-bottom: 0.25rem;
        }

        .register-header p {
            font-size: 0.85rem;
            opacity: 0.9;
            margin: 0;
        }

        .register-body {
            padding: 2rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-label i {
            color: var(--accent-blue);
        }

        .form-control {
            border: 1px solid var(--border-light);
            border-radius: 14px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
            outline: none;
        }

        .btn-register {
            background: var(--accent-gradient);
            border: none;
            border-radius: 14px;
            padding: 0.85rem;
            font-weight: 700;
            font-size: 1rem;
            width: 100%;
            color: white;
            transition: all 0.3s ease;
            margin-top: 0.5rem;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(67, 97, 238, 0.4);
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-light);
        }

        .login-link a {
            color: var(--accent-blue);
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            color: var(--accent-purple);
            text-decoration: underline;
        }

        .alert-custom {
            border-radius: 14px;
            padding: 0.85rem 1rem;
            margin-bottom: 1.5rem;
            font-size: 0.85rem;
        }

        .alert-danger-custom {
            background: #FEE2E2;
            color: #991B1B;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 576px) {
            .register-header {
                padding: 1.5rem;
            }
            .register-body {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>

<div class="register-card">
    <div class="register-header">
        <div class="logo-icon">
            <i class="bi bi-person-plus"></i>
        </div>
        <h2>Daftar Akun</h2>
        <p>Bergabung dengan perpustakaan digital</p>
    </div>

    <div class="register-body">
        @if($errors->any())
            <div class="alert alert-danger-custom alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">
                    <i class="bi bi-person"></i> Nama Lengkap
                </label>
                <input type="text" 
                       name="name" 
                       class="form-control" 
                       placeholder="Masukkan nama lengkap"
                       value="{{ old('name') }}"
                       required>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="bi bi-envelope"></i> Alamat Email
                </label>
                <input type="email" 
                       name="email" 
                       class="form-control" 
                       placeholder="email@example.com"
                       value="{{ old('email') }}"
                       required>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="bi bi-lock"></i> Password
                </label>
                <input type="password" 
                       name="password" 
                       class="form-control" 
                       placeholder="Minimal 8 karakter"
                       required>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="bi bi-lock-fill"></i> Konfirmasi Password
                </label>
                <input type="password" 
                       name="password_confirmation" 
                       class="form-control" 
                       placeholder="Ulangi password"
                       required>
            </div>

            <button type="submit" class="btn-register">
                <i class="bi bi-person-plus me-2"></i> Daftar Sekarang
            </button>
        </form>

        <div class="login-link">
            <span class="text-muted">Sudah punya akun?</span>
            <a href="{{ route('login') }}"> Login di sini</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>