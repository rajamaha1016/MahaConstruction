<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login | Maha Constructions</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Readex+Pro:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body {
            min-height: 100vh;
            font-family: 'Readex Pro', sans-serif;
            background: #050B14;
            display: flex; align-items: center; justify-content: center;
            color: #F0EBE0;
        }
        .login-wrapper {
            width: 100%; max-width: 480px; padding: 24px;
        }
        .login-card {
            background: #0B132B;
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-radius: 24px;
            padding: 48px 44px;
            box-shadow: 0 40px 100px rgba(0,0,0,0.6);
        }
        .login-logo { text-align: center; margin-bottom: 36px; }
        .login-icon {
            width: 72px; height: 72px;
            background: rgba(212, 175, 55, 0.12);
            border: 1.5px solid rgba(212, 175, 55, 0.4);
            border-radius: 18px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 1.8rem; color: #D4AF37; margin-bottom: 16px;
        }
        .login-brand { font-size: 1.3rem; font-weight: 800; color: #fff; letter-spacing: 0.05em; }
        .login-sub { font-size: 0.75rem; font-weight: 700; color: #D4AF37; letter-spacing: 0.15em; margin-top: 4px; text-transform: uppercase; }

        .error-box {
            background: rgba(255,59,48,0.12); border: 1px solid rgba(255,59,48,0.35);
            color: #FF3B30; border-radius: 10px; padding: 12px 16px; margin-bottom: 20px; font-size: 0.88rem;
        }

        .field-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 20px; }
        .field-label { font-size: 0.72rem; font-weight: 800; color: #D4AF37; letter-spacing: 0.1em; text-transform: uppercase; }
        .field-input {
            width: 100%; background: #050B14;
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-radius: 10px; padding: 14px 18px;
            color: #F0EBE0; font-size: 0.95rem; font-family: 'Readex Pro', sans-serif;
            outline: none; transition: border-color 0.2s;
        }
        .field-input::placeholder { color: #94A3B8; }
        .field-input:focus { border-color: #D4AF37; }

        .btn-login {
            width: 100%; padding: 14px;
            background: linear-gradient(135deg, #D4AF37, #B89228);
            color: #050B14; font-weight: 800; font-size: 0.95rem; letter-spacing: 0.05em;
            border: none; border-radius: 12px; cursor: pointer;
            box-shadow: 0 6px 20px rgba(212,175,55,0.3); transition: all 0.2s;
            font-family: 'Readex Pro', sans-serif;
        }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 10px 30px rgba(212,175,55,0.4); }

        .back-link { text-align: center; margin-top: 20px; }
        .back-link a { color: #94A3B8; font-size: 0.85rem; text-decoration: none; }
        .back-link a:hover { color: #D4AF37; }

        .footer-note { text-align: center; margin-top: 28px; font-size: 0.72rem; color: #4B5D6B; }

        @media (max-width: 480px) {
            .login-wrapper { padding: 14px; }
            .login-card { padding: 32px 20px; border-radius: 18px; }
            .login-icon { width: 56px; height: 56px; font-size: 1.4rem; border-radius: 14px; }
            .login-brand { font-size: 1.15rem; }
            .login-sub { font-size: 0.68rem; }
        }
    </style>
</head>
<body>
<div class="login-wrapper">
    <div class="login-card">
        <div class="login-logo">
            <div class="login-icon"><i class="fas fa-building"></i></div>
            <div class="login-brand">MAHA CONSTRUCTIONS</div>
            <div class="login-sub">Admin Control Panel</div>
        </div>

        @if($errors->any())
        <div class="error-box">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}">
            @csrf
            <div class="field-group">
                <label class="field-label">Admin Email</label>
                <input type="email" name="email" class="field-input" required
                       value="{{ old('email') }}"
                       placeholder="Mahaconstructions2013@gmail.com">
            </div>
            <div class="field-group" style="margin-bottom: 32px;">
                <label class="field-label">Password</label>
                <input type="password" name="password" class="field-input" required
                       placeholder="Enter admin password">
            </div>
            <button type="submit" class="btn-login">SIGN IN TO ADMIN PANEL <i class="fas fa-arrow-right" style="margin-left:6px;"></i></button>
        </form>

        <div class="back-link">
            <a href="{{ route('home') }}"><i class="fas fa-arrow-left" style="margin-right:6px;"></i> Back to Main Website</a>
        </div>
    </div>

    <p class="footer-note">© {{ date('Y') }} Maha Constructions. Er. Maha Rajan (Govt. Registered Engineer). All rights reserved.</p>
</div>
</body>
</html>
