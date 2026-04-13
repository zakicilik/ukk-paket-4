{{-- resources/views/auth/login.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login | Perpustakaan Digital</title>

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
            --accent-blue: #4361EE;
            --accent-purple: #7B2CBF;
            --accent-gradient: linear-gradient(135deg, #4361EE, #7B2CBF);
            --text-primary: #1F2937;
            --text-secondary: #6B7280;
            --bg-light: #F5F7FA;
            --card-white: #FFFFFF;
            --border-light: #E5E7EB;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.05), 0 1px 2px rgba(0, 0, 0, 0.1);
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

        /* Card Login */
        .login-card {
            background: var(--card-white);
            border-radius: 32px;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            max-width: 480px;
            width: 100%;
            animation: fadeInUp 0.5s ease;
        }

        .login-header {
            background: var(--accent-gradient);
            padding: 2rem;
            text-align: center;
            color: white;
        }

        .login-header .logo-icon {
            font-size: 3rem;
            margin-bottom: 0.5rem;
        }

        .login-header h2 {
            font-weight: 800;
            font-size: 1.8rem;
            margin-bottom: 0.25rem;
        }

        .login-header p {
            font-size: 0.85rem;
            opacity: 0.9;
            margin: 0;
        }

        .login-body {
            padding: 2rem;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1.5rem;
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
            font-size: 1rem;
        }

        .form-control {
            border: 1px solid var(--border-light);
            border-radius: 14px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-control:focus {
            border-color: var(--accent-blue);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
            outline: none;
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
            color: var(--text-secondary);
            background: transparent;
            border: none;
            z-index: 10;
        }

        /* Button */
        .btn-login {
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

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(67, 97, 238, 0.4);
        }

        /* Link */
        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-light);
        }

        .register-link a {
            color: var(--accent-blue);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s;
        }

        .register-link a:hover {
            color: var(--accent-purple);
            text-decoration: underline;
        }

        /* Alert */
        .alert-custom {
            border-radius: 14px;
            padding: 0.85rem 1rem;
            margin-bottom: 1.5rem;
            border: none;
            font-size: 0.85rem;
        }

        .alert-danger-custom {
            background: #FEE2E2;
            color: #991B1B;
        }

        .alert-success-custom {
            background: #D1FAE5;
            color: #065F46;
        }

        /* Remember me */
        .remember-checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 1rem 0;
        }

        .remember-checkbox input {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: var(--accent-blue);
        }

        .remember-checkbox label {
            font-size: 0.85rem;
            color: var(--text-secondary);
            cursor: pointer;
            margin: 0;
        }

        /* Animation */
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
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="login-header">
        <div class="logo-icon">
            <i class="bi bi-stack"></i>
        </div>
        <h2>Libra<span style="font-weight: 400;">Core</span></h2>
        <p>Perpustakaan Digital</p>
    </div>

    <div class="login-body">
        @if(session('error'))
            <div class="alert alert-danger-custom alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success-custom alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
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
                       placeholder="admin@perpus.com"
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
                <i class="bi bi-box-arrow-in-right me-2"></i> Masuk ke Dashboard
            </button>
        </form>

        <div class="register-link">
            <span class="text-muted">Belum punya akun?</span>
            <a href="{{ route('register') }}"> Daftar Sekarang</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('i').classList.toggle('bi-eye');
            this.querySelector('i').classList.toggle('bi-eye-slash');
        });
    }

    // Auto close alerts after 5 seconds
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(alert => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
</script>
</body>
</html>