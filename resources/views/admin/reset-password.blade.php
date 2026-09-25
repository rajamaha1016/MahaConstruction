<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create New Password | Maha Constructions</title>
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
            border: 1px solid rgba(212, 175, 55, 0.35);
            border-radius: 24px;
            padding: 44px 40px;
            box-shadow: 0 40px 100px rgba(0,0,0,0.65);
            position: relative;
            overflow: hidden;
        }
        .login-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, transparent, #D4AF37, transparent);
        }
        .login-logo { text-align: center; margin-bottom: 28px; }
        .login-icon {
            width: 68px; height: 68px;
            background: rgba(212, 175, 55, 0.12);
            border: 1.5px solid rgba(212, 175, 55, 0.4);
            border-radius: 18px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 1.8rem; color: #D4AF37; margin-bottom: 14px;
        }
        .login-brand { font-family: 'Montserrat', sans-serif; font-size: 1.25rem; font-weight: 800; color: #fff; letter-spacing: 0.05em; }
        .login-sub { font-family: 'Montserrat', sans-serif; font-size: 0.72rem; font-weight: 700; color: #D4AF37; letter-spacing: 0.15em; margin-top: 4px; text-transform: uppercase; }

        .alert-box {
            border-radius: 10px; padding: 12px 16px; margin-bottom: 20px; font-size: 0.88rem;
            font-family: 'Inter', sans-serif; display: flex; align-items: center; gap: 10px;
        }
        .alert-danger {
            background: rgba(255, 59, 48, 0.12);
            border: 1px solid rgba(255, 59, 48, 0.35);
            color: #FF6B6B;
        }
        .alert-success {
            background: rgba(52, 199, 89, 0.12);
            border: 1px solid rgba(52, 199, 89, 0.35);
            color: #34C759;
        }

        .section-desc {
            font-size: 0.85rem; color: #94A3B8; line-height: 1.45; margin-bottom: 22px; text-align: center;
        }

        .field-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 20px; }
        .field-label { font-family: 'Montserrat', sans-serif; font-size: 0.72rem; font-weight: 700; color: #D4AF37; letter-spacing: 0.1em; text-transform: uppercase; }
        .field-input {
            width: 100%; background: #050B14;
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-radius: 10px; padding: 13px 16px;
            color: #F0EBE0; font-size: 0.95rem; font-family: 'Inter', sans-serif;
            outline: none; transition: border-color 0.2s, box-shadow 0.2s;
        }
        .field-input::placeholder { color: #64748B; }
        .field-input:focus {
            border-color: #D4AF37;
            box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.2);
        }

        .input-wrapper { position: relative; width: 100%; }
        .input-wrapper .field-input { padding-right: 46px; }
        .btn-pwd-toggle {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
            background: none; border: none; color: #94A3B8; cursor: pointer; padding: 6px;
            font-size: 1rem; display: flex; align-items: center; justify-content: center;
            transition: color 0.2s;
        }
        .btn-pwd-toggle:hover { color: #D4AF37; }

        .field-hint {
            font-size: 0.75rem; color: #64748B; margin-top: 3px;
        }

        .pwd-strength-container { margin-top: 6px; }
        .pwd-strength-bar { display: flex; gap: 4px; height: 4px; margin-bottom: 5px; }
        .pwd-strength-bar div { flex: 1; height: 100%; border-radius: 2px; background: rgba(255,255,255,0.1); transition: background 0.25s; }

        .btn-primary {
            width: 100%; padding: 14px;
            background: linear-gradient(135deg, #D4AF37, #B89228);
            color: #050B14; font-weight: 700; font-size: 0.92rem; letter-spacing: 0.05em;
            border: none; border-radius: 12px; cursor: pointer;
            box-shadow: 0 6px 20px rgba(212,175,55,0.25); transition: all 0.2s;
            font-family: 'Montserrat', sans-serif; display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-primary:hover:not(:disabled) {
            transform: translateY(-2px); box-shadow: 0 10px 30px rgba(212,175,55,0.38);
        }
        .btn-primary:disabled {
            opacity: 0.65; cursor: not-allowed; transform: none; box-shadow: none;
        }

        .back-link { text-align: center; margin-top: 22px; font-family: 'Montserrat', sans-serif; font-weight: 600; }
        .back-link a { color: #94A3B8; font-size: 0.82rem; text-decoration: none; transition: color 0.2s; }
        .back-link a:hover { color: #D4AF37; }

        .footer-note { text-align: center; margin-top: 26px; font-size: 0.72rem; color: #4B5D6B; font-family: 'Inter', sans-serif; }

        .spinner {
            display: inline-block; width: 16px; height: 16px;
            border: 2px solid rgba(5, 11, 20, 0.3); border-radius: 50%;
            border-top-color: #050B14; animation: spin 0.7s linear infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }

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
            <div class="login-icon"><i class="fas fa-lock"></i></div>
            <div class="login-brand">MAHA CONSTRUCTIONS</div>
            <div class="login-sub">Create New Password</div>
        </div>

        @if($errors->any())
        <div class="alert-box alert-danger" id="serverErrorBox">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ $errors->first() }}</span>
        </div>
        @endif

        <div class="alert-box alert-danger" id="clientErrorBox" style="display:none;">
            <i class="fas fa-exclamation-circle"></i>
            <span id="clientErrorMsg"></span>
        </div>
        <div class="alert-box alert-success" id="clientSuccessBox" style="display:none;">
            <i class="fas fa-check-circle"></i>
            <span id="clientSuccessMsg"></span>
        </div>

        <p class="section-desc">
            Please enter and confirm your new administrator password (minimum 6 characters).
        </p>

        <form id="resetPwdForm" method="POST" action="{{ route('admin.reset_password.post') }}" onsubmit="handleResetPasswordSubmit(event)">
            @csrf
            <input type="hidden" name="token" id="resetToken" value="{{ $token }}">
            <input type="hidden" name="reset_token" value="{{ $token }}">
            <input type="hidden" name="email" id="resetEmail" value="{{ $email }}">

            <div class="field-group">
                <label class="field-label" for="new_password">New Password</label>
                <div class="input-wrapper">
                    <input type="password" id="new_password" name="new_password" class="field-input" required minlength="6"
                           placeholder="Enter new password (min. 6 characters)" autocomplete="new-password"
                           oninput="updatePasswordStrength(this.value)">
                    <button type="button" class="btn-pwd-toggle" onclick="togglePwd('new_password','newEyeIcon')"
                            title="Show / Hide Password" aria-label="Show or hide password">
                        <i class="fas fa-eye" id="newEyeIcon"></i>
                    </button>
                </div>
                <div class="pwd-strength-container">
                    <div class="pwd-strength-bar">
                        <div id="strengthBar1"></div>
                        <div id="strengthBar2"></div>
                        <div id="strengthBar3"></div>
                        <div id="strengthBar4"></div>
                    </div>
                    <span class="field-hint" id="strengthHint">Min. 6 characters. Use letters, numbers & symbols.</span>
                </div>
            </div>

            <div class="field-group" style="margin-bottom:28px;">
                <label class="field-label" for="new_password_confirmation">Confirm New Password</label>
                <div class="input-wrapper">
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="field-input" required minlength="6"
                           placeholder="Re-enter new password" autocomplete="new-password">
                    <button type="button" class="btn-pwd-toggle" onclick="togglePwd('new_password_confirmation','confirmEyeIcon')"
                            title="Show / Hide Password" aria-label="Show or hide password">
                        <i class="fas fa-eye" id="confirmEyeIcon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" id="resetSubmitBtn" class="btn-primary">
                <span id="resetBtnText">RESET PASSWORD</span>
                <i class="fas fa-check" id="resetBtnIcon"></i>
            </button>

            <div class="back-link">
                <a href="{{ route('admin.login') }}"><i class="fas fa-arrow-left"></i> Cancel</a>
            </div>
        </form>
    </div>

    <p class="footer-note">© {{ date('Y') }} Maha Constructions. Er. Maha Rajan (Govt. Registered Engineer). All rights reserved.</p>
</div>

<script>
function togglePwd(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (!input || !icon) return;
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

function showError(msg) {
    const box = document.getElementById('clientErrorBox');
    const txt = document.getElementById('clientErrorMsg');
    const successBox = document.getElementById('clientSuccessBox');
    const serverBox = document.getElementById('serverErrorBox');
    if (serverBox) serverBox.style.display = 'none';
    if (successBox) successBox.style.display = 'none';
    txt.textContent = msg;
    box.style.display = 'flex';
}

function showSuccess(msg) {
    const box = document.getElementById('clientSuccessBox');
    const txt = document.getElementById('clientSuccessMsg');
    const errorBox = document.getElementById('clientErrorBox');
    const serverBox = document.getElementById('serverErrorBox');
    if (serverBox) serverBox.style.display = 'none';
    if (errorBox) errorBox.style.display = 'none';
    txt.textContent = msg;
    box.style.display = 'flex';
}

function clearAlerts() {
    const errorBox = document.getElementById('clientErrorBox');
    const successBox = document.getElementById('clientSuccessBox');
    if (errorBox) errorBox.style.display = 'none';
    if (successBox) successBox.style.display = 'none';
}

function updatePasswordStrength(val) {
    const hint = document.getElementById('strengthHint');
    const bar1 = document.getElementById('strengthBar1');
    const bar2 = document.getElementById('strengthBar2');
    const bar3 = document.getElementById('strengthBar3');
    const bar4 = document.getElementById('strengthBar4');
    const bars = [bar1, bar2, bar3, bar4];

    bars.forEach(b => {
        b.style.background = 'rgba(255,255,255,0.1)';
    });

    if (!val) {
        hint.textContent = 'Min. 6 characters. Use letters, numbers & symbols.';
        hint.style.color = '#64748B';
        return;
    }

    if (val.length < 6) {
        bar1.style.background = '#FF6B6B';
        hint.textContent = `Too short (${val.length}/6 characters minimum)`;
        hint.style.color = '#FF6B6B';
        return;
    }

    let score = 0;
    if (val.length >= 6) score++;
    if (/[A-Z]/.test(val) && /[a-z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    if (score <= 1) {
        bar1.style.background = '#FF6B6B';
        hint.textContent = 'Weak: Add numbers, uppercase and symbols.';
        hint.style.color = '#FF6B6B';
    } else if (score === 2) {
        bar1.style.background = '#FFA500';
        bar2.style.background = '#FFA500';
        hint.textContent = 'Medium: Add symbols or more variety.';
        hint.style.color = '#FFA500';
    } else if (score === 3) {
        bar1.style.background = '#D4AF37';
        bar2.style.background = '#D4AF37';
        bar3.style.background = '#D4AF37';
        hint.textContent = 'Good password strength.';
        hint.style.color = '#D4AF37';
    } else {
        bars.forEach(b => b.style.background = '#34C759');
        hint.textContent = 'Strong password.';
        hint.style.color = '#34C759';
    }
}

async function handleResetPasswordSubmit(e) {
    e.preventDefault();
    clearAlerts();

    const newPwd = document.getElementById('new_password').value;
    const confirmPwd = document.getElementById('new_password_confirmation').value;
    const token = document.getElementById('resetToken').value;
    const email = document.getElementById('resetEmail').value;

    if (!newPwd || newPwd.length < 6) {
        showError('Password must be at least 6 characters long.');
        document.getElementById('new_password').focus();
        return;
    }

    if (newPwd !== confirmPwd) {
        showError('Passwords do not match.');
        document.getElementById('new_password_confirmation').focus();
        return;
    }

    const btn = document.getElementById('resetSubmitBtn');
    const txt = document.getElementById('resetBtnText');
    const icon = document.getElementById('resetBtnIcon');

    btn.disabled = true;
    txt.textContent = 'RESETTING PASSWORD...';
    icon.className = 'spinner';

    try {
        const res = await fetch('{{ route("admin.reset_password.post") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                email: email,
                reset_token: token,
                token: token,
                new_password: newPwd,
                new_password_confirmation: confirmPwd
            })
        });

        const data = await res.json();

        if (res.ok) {
            showSuccess('Password reset successfully. Redirecting to login...');
            setTimeout(() => {
                window.location.href = "{{ route('admin.login') }}?reset=success";
            }, 900);
        } else {
            showError(data.message || data.detail || 'Password reset failed. Please request a new link.');
            btn.disabled = false;
            txt.textContent = 'RESET PASSWORD';
            icon.className = 'fas fa-check';
        }
    } catch (err) {
        // Fallback to standard form submission if fetch/network issue
        document.getElementById('resetPwdForm').submit();
    }
}
</script>
</body>
</html>
