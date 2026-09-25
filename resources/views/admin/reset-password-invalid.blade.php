<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Invalid Reset Link | Maha Constructions</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body {
            min-height: 100vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: #050B14;
            display: flex; align-items: center; justify-content: center;
            color: #F0EBE0;
        }
        .login-wrapper {
            width: 100%; max-width: 500px; padding: 24px;
        }
        .login-card {
            background: #0B132B;
            border: 1px solid rgba(255, 59, 48, 0.35);
            border-radius: 24px;
            padding: 44px 40px;
            box-shadow: 0 40px 100px rgba(0,0,0,0.65);
            position: relative;
            overflow: hidden;
            text-align: center;
        }
        .login-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, transparent, #FF3B30, transparent);
        }
        .login-logo { margin-bottom: 24px; }
        .login-icon {
            width: 72px; height: 72px;
            background: rgba(255, 59, 48, 0.12);
            border: 1.5px solid rgba(255, 59, 48, 0.45);
            border-radius: 20px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 2rem; color: #FF6B6B; margin-bottom: 16px;
        }
        .login-brand { font-family: 'Montserrat', sans-serif; font-size: 1.25rem; font-weight: 800; color: #fff; letter-spacing: 0.05em; }
        .login-sub { font-family: 'Montserrat', sans-serif; font-size: 0.75rem; font-weight: 700; color: #FF6B6B; letter-spacing: 0.15em; margin-top: 4px; text-transform: uppercase; }

        .alert-box {
            border-radius: 12px; padding: 18px 20px; margin: 24px 0 28px; font-size: 0.95rem;
            font-family: 'Inter', sans-serif; display: flex; align-items: center; gap: 12px;
            background: rgba(255, 59, 48, 0.12);
            border: 1px solid rgba(255, 59, 48, 0.4);
            color: #FF8E8E; line-height: 1.5; text-align: left;
        }

        .btn-primary {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            width: 100%; padding: 14px;
            background: linear-gradient(135deg, #D4AF37, #B89228);
            color: #050B14; font-weight: 700; font-size: 0.92rem; letter-spacing: 0.05em;
            border: none; border-radius: 12px; cursor: pointer; text-decoration: none;
            box-shadow: 0 6px 20px rgba(212,175,55,0.25); transition: all 0.2s;
            font-family: 'Montserrat', sans-serif;
        }
        .btn-primary:hover {
            transform: translateY(-2px); box-shadow: 0 10px 30px rgba(212,175,55,0.38); color: #050B14;
        }

        .footer-note { text-align: center; margin-top: 26px; font-size: 0.72rem; color: #4B5D6B; font-family: 'Inter', sans-serif; }
    </style>
</head>
<body>
<div class="login-wrapper">
    <div class="login-card">
        <div class="login-logo">
            <div class="login-icon"><i class="fas fa-exclamation-triangle"></i></div>
            <div class="login-brand">MAHA CONSTRUCTIONS</div>
            <div class="login-sub">Reset Link Expired</div>
        </div>

        <div class="alert-box">
            <i class="fas fa-exclamation-circle" style="font-size: 1.3rem; flex-shrink: 0; color: #FF6B6B;"></i>
            <span>{{ $errorMessage ?? 'This password reset link is invalid or has expired. Please request a new password reset.' }}</span>
        </div>

        <a href="{{ route('admin.login') }}" class="btn-primary">
            <i class="fas fa-arrow-left"></i> Return to Admin Login
        </a>
    </div>

    <p class="footer-note">© {{ date('Y') }} Maha Constructions. Er. Maha Rajan (Govt. Registered Engineer). All rights reserved.</p>
</div>
</body>
</html>
