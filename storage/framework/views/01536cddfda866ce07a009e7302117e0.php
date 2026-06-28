<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Restoran</title>
    <style>
        :root {
            --theme-start: #0f766e;
            --theme-end: #115e59;
            --theme-main: #0f766e;
            --theme-accent: #f97316;
            --theme-ink: #17202a;
            --theme-muted: #657386;
            --theme-line: #dbe3ee;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--theme-ink) 0%, var(--theme-end) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.22);
            width: 100%;
            max-width: 400px;
            padding: 40px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .login-icon {
            font-size: 3em;
            margin-bottom: 15px;
        }

        .login-title {
            font-size: 1.8em;
            font-weight: 700;
            color: var(--theme-ink);
            margin-bottom: 5px;
        }

        .login-subtitle {
            color: var(--theme-muted);
            font-size: 0.95em;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--theme-ink);
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid var(--theme-line);
            border-radius: 8px;
            font-size: 1em;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--theme-main);
            box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.14);
        }

        .error-message {
            color: #991b1b;
            background: #fee2e2;
            border: 1px solid #fecaca;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 0.9em;
        }

        .login-btn {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, var(--theme-main) 0%, var(--theme-accent) 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1em;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(249, 115, 22, 0.28);
        }

        .login-footer {
            text-align: center;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid var(--theme-line);
        }

        .back-link {
            color: var(--theme-main);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .back-link:hover {
            color: var(--theme-accent);
        }

        .demo-credentials {
            background: #f0fdfa;
            border-left: 4px solid var(--theme-main);
            padding: 12px;
            border-radius: 4px;
            margin-top: 15px;
            font-size: 0.85em;
            color: var(--theme-end);
        }

        @media (max-width: 600px) {
            .login-container {
                padding: 30px 20px;
            }

            .login-title {
                font-size: 1.4em;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Header -->
        <div class="login-header">
            <div class="login-icon">🔐</div>
            <div class="login-title">Admin Login</div>
            <div class="login-subtitle">Kelola pesanan dan status</div>
        </div>

        <!-- Error Messages -->
        <?php if($errors->any()): ?>
            <div class="error-message">
                ⚠️ <?php echo e($errors->first('credentials')); ?>

            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form method="POST" action="<?php echo e(route('admin.authenticate')); ?>">
            <?php echo csrf_field(); ?>

            <div class="form-group">
                <label class="form-label">👤 Username</label>
                <input 
                    type="text" 
                    name="username" 
                    class="form-input" 
                    value="<?php echo e(old('username')); ?>"
                    placeholder="Masukkan username"
                    required
                >
            </div>

            <div class="form-group">
                <label class="form-label">🔑 Password</label>
                <input 
                    type="password" 
                    name="password" 
                    class="form-input" 
                    placeholder="Masukkan password"
                    required
                >
            </div>

            <button type="submit" class="login-btn">✓ Login Admin</button>

            <!-- Demo Credentials -->
            <div class="demo-credentials">
                <strong>Akun Demo:</strong><br>
                Username: <code>admin</code><br>
                Password: <code>admin123</code>
            </div>
        </form>

        <!-- Footer -->
        <div class="login-footer">
            <a href="<?php echo e(route('menu.index')); ?>" class="back-link">← Kembali ke Menu Pelanggan</a>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\c7\resources\views/admin/login.blade.php ENDPATH**/ ?>