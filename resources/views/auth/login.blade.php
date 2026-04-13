{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | LibraCore Perpustakaan Digital</title>

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
            /* Warna dengan aturan 60-30-10 (SAMA DENGAN USER PANEL) */
            --color-60: #F5F0E8;  /* 60% - Warna netral krem hangat (background card) */
            --color-30: #2C3E50;  /* 30% - Warna navy gelap (header, sidebar) */
            --color-10: #D4A373;  /* 10% - Warna aksen terracotta/gold (tombol, ikon) */
            
            /* Warna pendukung */
            --color-10-light: #E6C9A8;
            --color-10-dark: #C28A5A;
            --color-30-light: #3D5166;
            --color-30-dark: #1A2A3A;
            --text-light: #F5F0E8;
            --text-dark: #2C3E50;
            --text-muted: #6B7280;
            
            /* Shadow & Border */
            --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            --card-shadow-hover: 0 8px 30px rgba(0, 0, 0, 0.15);
            --border-light: rgba(44, 62, 80, 0.1);
        }

        body {
            background: linear-gradient(135deg, var(--color-30) 0%, var(--color-30-dark) 100%);
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        /* Background decoration */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 80%, rgba(212, 163, 115, 0.1) 0%, transparent 50%);
            pointer-events: none;
        }

        body::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 80% 20%, rgba(212, 163, 115, 0.08) 0%, transparent 50%);
            pointer-events: none;
        }

        /* Golden Ratio untuk Card Login (1.618) */
        .login-card {
            background: var(--color-60);
            border-radius: 34px; /* 21 × 1.618 = 34 */
            box-shadow: var(--card-shadow);
            overflow: hidden;
            max-width: 460px;
            width: 100%;
            animation: fadeInUp 0.6s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            position: relative;
            z-index: 1;
        }

        /* Golden Ratio untuk Header */
        .login-header {
            background: var(--color-30);
            padding: 2rem 2rem 1.8rem;
            text-align: center;
            color: var(--text-light);
            position: relative;
        }

        .login-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, var(--color-10), var(--color-10-light));
            border-radius: 3px;
        }

        .login-header .logo-icon {
            font-size: 3.2rem;
            margin-bottom: 0.75rem;
            background: linear-gradient(135deg, var(--color-10), var(--color-10-light));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            display: inline-block;
        }

        .login-header h2 {
            font-weight: 800;
            font-size: 2rem;
            margin-bottom: 0.25rem;
            letter-spacing: -0.5px;
        }

        .login-header h2 span {
            color: var(--color-10);
            font-weight: 400;
        }

        .login-header p {
            font-size: 0.85rem;
            opacity: 0.75;
            margin: 0;
        }

        .login-body {
            padding: 2rem 2rem 2rem;
        }

        /* Form Styles - Golden Ratio */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--color-30);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-label i {
            color: var(--color-10);
            font-size: 1rem;
        }

        .form-control {
            border: 1.5px solid var(--border-light);
            border-radius: 13px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            font-family: inherit;
            background: white;
        }

        .form-control:focus {
            border-color: var(--color-10);
            box-shadow: 0 0 0 3px rgba(212, 163, 115, 0.15);
            outline: none;
        }

        .form-control::placeholder {
            color: #C0B7A8;
            font-size: 0.85rem;
        }

        .input-group-custom {
            position: relative;
        }

        .input-group-custom .toggle-password {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--text-muted);
            background: transparent;
            border: none;
            z-index: 10;
            transition: color 0.2s;
        }

        .input-group-custom .toggle-password:hover {
            color: var(--color-10);
        }

        /* Button - Golden Ratio */
        .btn-login {
            background: linear-gradient(135deg, var(--color-10), var(--color-10-dark));
            border: none;
            border-radius: 13px;
            padding: 0.85rem;
            font-weight: 700;
            font-size: 1rem;
            width: 100%;
            color: white;
            transition: all 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(212, 163, 115, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* Link */
        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-light);
        }

        .register-link .text-muted {
            color: var(--text-muted) !important;
            font-size: 0.85rem;
        }

        .register-link a {
            color: var(--color-10);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s;
            margin-left: 4px;
        }

        .register-link a:hover {
            color: var(--color-10-dark);
            text-decoration: underline;
        }

        /* Alert */
        .alert-custom {
            border-radius: 13px;
            padding: 0.85rem 1rem;
            margin-bottom: 1.5rem;
            border: none;
            font-size: 0.85rem;
            animation: slideIn 0.3s ease;
        }

        .alert-danger-custom {
            background: #FEE2E2;
            color: #991B1B;
            border-left: 4px solid #DC3545;
        }

        .alert-success-custom {
            background: #D1FAE5;
            color: #065F46;
            border-left: 4px solid #10B981;
        }

        /* Remember me */
        .remember-checkbox {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 1rem 0 1.2rem;
        }

        .remember-checkbox input {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: var(--color-10);
        }

        .remember-checkbox label {
            font-size: 0.85rem;
            color: var(--text-muted);
            cursor: pointer;
            margin: 0;
        }

        /* Demo info card */
        .demo-info {
            background: rgba(212, 163, 115, 0.08);
            border-radius: 13px;
            padding: 0.85rem;
            margin-top: 1.5rem;
            text-align: center;
            border: 1px dashed var(--border-light);
        }

        .demo-info small {
            color: var(--color-30);
            font-size: 0.75rem;
        }

        .demo-info .badge-demo {
            background: var(--color-10);
            color: white;
            padding: 0.2rem 0.6rem;
            border-radius: 30px;
            font-size: 0.65rem;
            font-weight: 600;
            margin-right: 6px;
        }

        .demo-info strong {
            color: var(--color-10-dark);
            font-weight: 600;
        }

        /* Animations */
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

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Responsive */
        @media (max-width: 576px) {
            body {
                padding: 1rem;
            }
            .login-header {
                padding: 1.5rem;
            }
            .login-body {
                padding: 1.5rem;
            }
            .login-header h2 {
                font-size: 1.5rem;
            }
            .login-header .logo-icon {
                font-size: 2.5rem;
            }
            .login-card {
                border-radius: 24px;
            }
            .btn-login {
                padding: 0.7rem;
            }
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-header">
        <div class="logo-icon">
            <i class="bi bi-stack"></i>
        </div>
        <h2>Libra<span>Core</span></h2>
        <p>Perpustakaan Digital</p>
    </div>

    <div class="login-body">
        @if(session('error'))
            <div class="alert alert-danger-custom alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success-custom alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">
                    <i class="bi bi-envelope"></i> Alamat Email
                </label>
                <input type="email" 
                       name="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       placeholder="user@libracore.id"
                       value="{{ old('email') }}"
                       required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="bi bi-lock"></i> Password
                </label>
                <div class="input-group-custom">
                    <input type="password" 
                           name="password" 
                           id="password"
                           class="form-control @error('password') is-invalid @enderror" 
                           placeholder="Masukkan password"
                           required>
                    <button type="button" class="toggle-password" id="togglePassword">
                        <i class="bi bi-eye-slash"></i>
                    </button>
                </div>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="remember-checkbox">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Ingat saya</label>
            </div>

            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right"></i> 
                Masuk ke Dashboard
            </button>
        </form>

        <div class="demo-info">
            <small>
                <span class="badge-demo">Demo</span>
                Email: <strong>user@libracore.id</strong> | Password: <strong>password</strong>
            </small>
        </div>

        <div class="register-link">
            <span class="text-muted">Belum punya akun?</span>
            <a href="{{ route('register') }}">Daftar Sekarang</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    if (togglePassword && password) {
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            const icon = this.querySelector('i');
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        });
    }

    // Auto close alerts after 5 seconds
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(alert => {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            bsAlert.close();
        });
    }, 5000);
</script>
</body>
</html>