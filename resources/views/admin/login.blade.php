<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login | Maha Constructions</title>
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

        /* Alert boxes */
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

        /* Input with icon / toggle button */
        .input-wrapper { position: relative; width: 100%; }
        .input-wrapper .field-input { padding-right: 46px; }
        .btn-pwd-toggle {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
            background: none; border: none; color: #94A3B8; cursor: pointer; padding: 6px;
            font-size: 1rem; display: flex; align-items: center; justify-content: center;
            transition: color 0.2s;
        }
        .btn-pwd-toggle:hover { color: #D4AF37; }

        /* Remember & Forgot row */
        .row-options {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 24px; font-size: 0.84rem;
        }
        .checkbox-label {
            display: flex; align-items: center; gap: 8px; color: #94A3B8;
            cursor: pointer; user-select: none;
        }
        .checkbox-label input[type="checkbox"] {
            accent-color: #D4AF37; width: 16px; height: 16px; cursor: pointer;
        }
        .link-gold {
            color: #D4AF37; text-decoration: none; font-weight: 600;
            font-family: 'Inter', sans-serif; transition: color 0.2s;
            cursor: pointer; background: none; border: none; font-size: 0.84rem;
        }
        .link-gold:hover { color: #F3E5AB; text-decoration: underline; }

        /* Buttons */
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

        .btn-secondary {
            width: 100%; padding: 12px; margin-top: 10px;
            background: transparent; color: #94A3B8; font-weight: 600; font-size: 0.88rem;
            border: 1px solid rgba(148, 163, 184, 0.25); border-radius: 10px; cursor: pointer;
            transition: all 0.2s; font-family: 'Inter', sans-serif; display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .btn-secondary:hover { color: #F0EBE0; border-color: rgba(212, 175, 55, 0.5); }

        .back-link { text-align: center; margin-top: 22px; font-family: 'Montserrat', sans-serif; font-weight: 600; }
        .back-link a { color: #94A3B8; font-size: 0.82rem; text-decoration: none; transition: color 0.2s; }
        .back-link a:hover { color: #D4AF37; }

        .footer-note { text-align: center; margin-top: 26px; font-size: 0.72rem; color: #4B5D6B; font-family: 'Inter', sans-serif; }

        /* 6-digit OTP Inputs */
        .otp-container {
            display: flex; gap: 8px; justify-content: space-between; margin-bottom: 20px;
        }
        .otp-input {
            width: 54px; height: 58px; text-align: center; font-size: 1.5rem; font-weight: 700;
            font-family: 'Montserrat', sans-serif; background: #050B14;
            border: 1.5px solid rgba(212, 175, 55, 0.35); border-radius: 10px; color: #D4AF37;
            outline: none; transition: all 0.2s;
        }
        .otp-input:focus {
            border-color: #D4AF37; box-shadow: 0 0 0 2px rgba(212, 175, 55, 0.3); background: #0B132B;
        }

        .otp-helper {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 20px; font-size: 0.82rem; color: #94A3B8;
        }
        .timer-badge {
            color: #D4AF37; font-weight: 700; font-family: 'Montserrat', sans-serif;
        }

        .section-desc {
            font-size: 0.85rem; color: #94A3B8; line-height: 1.45; margin-bottom: 22px; text-align: center;
        }

        .field-hint {
            font-size: 0.75rem; color: #64748B; margin-top: 3px;
        }

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
            .otp-input { width: 44px; height: 50px; font-size: 1.25rem; }
        }
    </style>
</head>
<body>
<div class="login-wrapper">
    <div class="login-card">
        <div class="login-logo">
            <div class="login-icon"><i class="fas fa-building"></i></div>
            <div class="login-brand">MAHA CONSTRUCTIONS</div>
            <div class="login-sub" id="cardSubtitle">Admin Control Panel</div>
        </div>

        <!-- Server side blade error box -->
        @if($errors->any())
        <div class="alert-box alert-danger" id="serverErrorBox">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ $errors->first() }}</span>
        </div>
        @endif

        <!-- Client dynamic alert boxes -->
        <div class="alert-box alert-danger" id="clientErrorBox" style="display:none;">
            <i class="fas fa-exclamation-circle"></i>
            <span id="clientErrorMsg"></span>
        </div>
        <div class="alert-box alert-success" id="clientSuccessBox" style="display:none;">
            <i class="fas fa-check-circle"></i>
            <span id="clientSuccessMsg"></span>
        </div>

        <!-- ========================================== -->
        <!-- VIEW 1: ADMIN LOGIN FORM                  -->
        <!-- ========================================== -->
        <div id="viewLogin">
            <form id="adminLoginForm" method="POST" action="{{ route('admin.login.post') }}" onsubmit="handleLoginSubmit(event)">
                @csrf
                <div class="field-group">
                    <label class="field-label" for="loginEmail">Admin Email</label>
                    <input type="email" name="email" id="loginEmail" class="field-input" required
                           value="{{ old('email') }}"
                           placeholder="Enter admin email" autocomplete="email">
                </div>

                <div class="field-group">
                    <label class="field-label" for="loginPassword">Password</label>
                    <div class="input-wrapper">
                        <input type="password" name="password" id="loginPassword" class="field-input" required
                               placeholder="Enter admin password" autocomplete="current-password">
                        <button type="button" class="btn-pwd-toggle" onclick="togglePwd('loginPassword','loginEyeIcon')"
                                title="Show / Hide Password" aria-label="Show or hide password">
                            <i class="fas fa-eye" id="loginEyeIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="row-options">
                    <label class="checkbox-label" for="rememberMe">
                        <input type="checkbox" name="remember" id="rememberMe">
                        <span>Remember me</span>
                    </label>
                    <button type="button" class="link-gold" onclick="switchView('forgotStep1')">
                        Forgot Password?
                    </button>
                </div>

                <button type="submit" id="loginSubmitBtn" class="btn-primary">
                    <span id="loginBtnText">SIGN IN TO ADMIN PANEL</span>
                    <i class="fas fa-arrow-right" id="loginBtnIcon"></i>
                </button>
            </form>

            <div class="back-link">
                <a href="{{ route('home') }}"><i class="fas fa-arrow-left" style="margin-right:6px;"></i> Back to Main Website</a>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- VIEW 2: FORGOT PASSWORD - STEP 1 (EMAIL)  -->
        <!-- ========================================== -->
        <div id="viewForgotStep1" style="display:none;">
            <p class="section-desc">
                Enter your registered admin email address. We will send a 6-digit verification code to reset your password.
            </p>

            <form id="forgotEmailForm" onsubmit="handleSendOtp(event)">
                <div class="field-group">
                    <label class="field-label" for="forgotEmail">Registered Admin Email</label>
                    <input type="email" id="forgotEmail" class="field-input" required
                           placeholder="admin@example.com" autocomplete="email">
                </div>

                <button type="submit" id="sendOtpBtn" class="btn-primary" style="margin-top:24px;">
                    <span id="sendOtpBtnText">SEND VERIFICATION CODE</span>
                    <i class="fas fa-paper-plane" id="sendOtpBtnIcon"></i>
                </button>
            </form>

            <button type="button" class="btn-secondary" onclick="switchView('login')">
                <i class="fas fa-arrow-left"></i> Back to Sign In
            </button>
        </div>

        <!-- ========================================== -->
        <!-- VIEW 3: FORGOT PASSWORD - STEP 2 (OTP & PWD) -->
        <!-- ========================================== -->
        <div id="viewForgotStep2" style="display:none;">
            <p class="section-desc">
                Enter the 6-digit verification code sent to <strong id="displayTargetEmail" style="color:#D4AF37;"></strong> and your new password.
            </p>

            <form id="resetPwdForm" onsubmit="handleResetPassword(event)">
                <div class="field-group" style="margin-bottom:12px;">
                    <label class="field-label">6-Digit Verification Code</label>
                    <div class="otp-container">
                        <input type="text" maxlength="1" class="otp-input" inputmode="numeric" pattern="[0-9]" data-idx="0">
                        <input type="text" maxlength="1" class="otp-input" inputmode="numeric" pattern="[0-9]" data-idx="1">
                        <input type="text" maxlength="1" class="otp-input" inputmode="numeric" pattern="[0-9]" data-idx="2">
                        <input type="text" maxlength="1" class="otp-input" inputmode="numeric" pattern="[0-9]" data-idx="3">
                        <input type="text" maxlength="1" class="otp-input" inputmode="numeric" pattern="[0-9]" data-idx="4">
                        <input type="text" maxlength="1" class="otp-input" inputmode="numeric" pattern="[0-9]" data-idx="5">
                    </div>
                </div>

                <div class="otp-helper">
                    <span>Code expires in: <span class="timer-badge" id="otpCountdown">10:00</span></span>
                    <button type="button" class="link-gold" id="resendOtpBtn" onclick="handleResendOtp()" style="font-size:0.8rem;">
                        Resend Code
                    </button>
                </div>

                <div class="field-group">
                    <label class="field-label" for="newPassword">New Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="newPassword" class="field-input" required minlength="8"
                               placeholder="Enter new password (min. 8 characters)" autocomplete="new-password">
                        <button type="button" class="btn-pwd-toggle" onclick="togglePwd('newPassword','newEyeIcon')"
                                title="Show / Hide Password" aria-label="Show or hide password">
                            <i class="fas fa-eye" id="newEyeIcon"></i>
                        </button>
                    </div>
                    <span class="field-hint">Must be at least 8 characters.</span>
                </div>

                <div class="field-group" style="margin-bottom:28px;">
                    <label class="field-label" for="confirmPassword">Confirm New Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="confirmPassword" class="field-input" required minlength="8"
                               placeholder="Re-enter new password" autocomplete="new-password">
                        <button type="button" class="btn-pwd-toggle" onclick="togglePwd('confirmPassword','confirmEyeIcon')"
                                title="Show / Hide Password" aria-label="Show or hide password">
                            <i class="fas fa-eye" id="confirmEyeIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" id="resetPwdBtn" class="btn-primary">
                    <span id="resetPwdBtnText">RESET PASSWORD</span>
                    <i class="fas fa-check" id="resetPwdBtnIcon"></i>
                </button>
            </form>

            <button type="button" class="btn-secondary" onclick="switchView('login')">
                <i class="fas fa-arrow-left"></i> Back to Sign In
            </button>
        </div>

    </div>

    <p class="footer-note">© {{ date('Y') }} Maha Constructions. Er. Maha Rajan (Govt. Registered Engineer). All rights reserved.</p>
</div>

<script>
// State variables
let activeResetEmail = '';
let otpTimerInterval = null;
let resendCooldownInterval = null;
let otpSecondsRemaining = 600; // 10 minutes
let resendSecondsRemaining = 0;

// Password visibility toggle
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

// Alert messaging
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

// View switcher
function switchView(target) {
    clearAlerts();
    const vLogin  = document.getElementById('viewLogin');
    const vStep1  = document.getElementById('viewForgotStep1');
    const vStep2  = document.getElementById('viewForgotStep2');
    const sub     = document.getElementById('cardSubtitle');

    vLogin.style.display = 'none';
    vStep1.style.display = 'none';
    vStep2.style.display = 'none';

    if (target === 'login') {
        vLogin.style.display = 'block';
        sub.textContent = 'Admin Control Panel';
    } else if (target === 'forgotStep1') {
        vStep1.style.display = 'block';
        sub.textContent = 'Password Recovery';
        const forgotInput = document.getElementById('forgotEmail');
        const loginEmail = document.getElementById('loginEmail');
        if (loginEmail && loginEmail.value.trim()) {
            forgotInput.value = loginEmail.value.trim();
        }
        forgotInput.focus();
    } else if (target === 'forgotStep2') {
        vStep2.style.display = 'block';
        sub.textContent = 'Verify Verification Code';
        document.getElementById('displayTargetEmail').textContent = activeResetEmail;
        focusFirstOtp();
    }
}

// Form submit loading state for web login
function handleLoginSubmit(e) {
    const btn  = document.getElementById('loginSubmitBtn');
    const txt  = document.getElementById('loginBtnText');
    const icon = document.getElementById('loginBtnIcon');
    const email = document.getElementById('loginEmail').value.trim();
    const pwd   = document.getElementById('loginPassword').value;

    if (!email) {
        e.preventDefault();
        showError('Please enter a valid email address.');
        return;
    }
    if (!pwd) {
        e.preventDefault();
        showError('Please enter your password.');
        return;
    }

    // Set loading indicator
    btn.disabled = true;
    txt.textContent = 'SIGNING IN...';
    icon.className = 'spinner';
}

// Step 1: Send OTP via API
async function handleSendOtp(e) {
    if (e) e.preventDefault();
    clearAlerts();

    const emailInput = document.getElementById('forgotEmail');
    const email = (emailInput.value || '').trim();

    if (!email || !email.includes('@') || !email.includes('.')) {
        showError('Please enter a valid email address.');
        emailInput.focus();
        return;
    }

    const btn = document.getElementById('sendOtpBtn');
    const txt = document.getElementById('sendOtpBtnText');
    const icon = document.getElementById('sendOtpBtnIcon');

    btn.disabled = true;
    txt.textContent = 'SENDING CODE...';
    icon.className = 'spinner';

    try {
        const res = await fetch('/api/auth/forgot-password', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ email: email })
        });

        const data = await res.json();

        if (res.ok) {
            activeResetEmail = email;
            startOtpCountdown();
            startResendCooldown(60);
            switchView('forgotStep2');
            showSuccess('If that email is registered, an OTP has been sent to it.');
        } else {
            showError(data.detail || data.message || 'Something went wrong. Please try again.');
        }
    } catch (err) {
        showError('Something went wrong. Please try again.');
    } finally {
        btn.disabled = false;
        txt.textContent = 'SEND VERIFICATION CODE';
        icon.className = 'fas fa-paper-plane';
    }
}

// Resend OTP
async function handleResendOtp() {
    if (resendSecondsRemaining > 0) return;
    clearAlerts();

    const resendBtn = document.getElementById('resendOtpBtn');
    resendBtn.disabled = true;
    resendBtn.textContent = 'Sending...';

    try {
        const res = await fetch('/api/auth/forgot-password', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ email: activeResetEmail })
        });

        const data = await res.json();
        if (res.ok) {
            showSuccess('A fresh 6-digit verification code has been dispatched.');
            startOtpCountdown();
            startResendCooldown(60);
        } else {
            showError(data.detail || data.message || 'Something went wrong. Please try again.');
            resendBtn.disabled = false;
            resendBtn.textContent = 'Resend Code';
        }
    } catch (err) {
        showError('Something went wrong. Please try again.');
        resendBtn.disabled = false;
        resendBtn.textContent = 'Resend Code';
    }
}

// Step 2: Reset Password via API
async function handleResetPassword(e) {
    if (e) e.preventDefault();
    clearAlerts();

    const otpDigits = Array.from(document.querySelectorAll('.otp-input')).map(i => i.value.trim()).join('');
    if (otpDigits.length !== 6 || !/^\d{6}$/.test(otpDigits)) {
        showError('Please enter all 6 digits of the verification code.');
        focusFirstOtp();
        return;
    }

    const newPwd = document.getElementById('newPassword').value;
    const confirmPwd = document.getElementById('confirmPassword').value;

    if (!newPwd || newPwd.length < 8) {
        showError('Password must be at least 8 characters.');
        document.getElementById('newPassword').focus();
        return;
    }

    if (newPwd !== confirmPwd) {
        showError('Passwords do not match.');
        document.getElementById('confirmPassword').focus();
        return;
    }

    const btn = document.getElementById('resetPwdBtn');
    const txt = document.getElementById('resetPwdBtnText');
    const icon = document.getElementById('resetPwdBtnIcon');

    btn.disabled = true;
    txt.textContent = 'RESETTING PASSWORD...';
    icon.className = 'spinner';

    try {
        const res = await fetch('/api/auth/reset-password', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                email: activeResetEmail,
                otp: otpDigits,
                new_password: newPwd,
                new_password_confirmation: confirmPwd
            })
        });

        const data = await res.json();

        if (res.ok) {
            showSuccess('Password reset successfully! Redirecting to login...');
            clearInterval(otpTimerInterval);
            clearInterval(resendCooldownInterval);

            // Pre-fill email on login form and clear password fields
            document.getElementById('loginEmail').value = activeResetEmail;
            document.getElementById('loginPassword').value = '';
            document.getElementById('newPassword').value = '';
            document.getElementById('confirmPassword').value = '';
            document.querySelectorAll('.otp-input').forEach(i => i.value = '');

            setTimeout(() => {
                switchView('login');
                showSuccess('Password reset successfully. Please log in with your new password.');
                document.getElementById('loginPassword').focus();
            }, 1600);
        } else {
            showError(data.detail || data.message || 'Invalid or expired OTP.');
            if ((data.detail || data.message || '').toLowerCase().includes('otp')) {
                focusFirstOtp();
            }
        }
    } catch (err) {
        showError('Something went wrong. Please try again.');
    } finally {
        btn.disabled = false;
        txt.textContent = 'RESET PASSWORD';
        icon.className = 'fas fa-check';
    }
}

// Countdown timer UX (10 minutes)
function startOtpCountdown() {
    clearInterval(otpTimerInterval);
    otpSecondsRemaining = 600;
    const badge = document.getElementById('otpCountdown');

    const updateDisplay = () => {
        const mins = Math.floor(otpSecondsRemaining / 60);
        const secs = otpSecondsRemaining % 60;
        badge.textContent = `${mins}:${secs < 10 ? '0' : ''}${secs}`;
    };
    updateDisplay();

    otpTimerInterval = setInterval(() => {
        otpSecondsRemaining--;
        if (otpSecondsRemaining <= 0) {
            clearInterval(otpTimerInterval);
            badge.textContent = 'Expired';
            showError('Invalid or expired OTP.');
        } else {
            updateDisplay();
        }
    }, 1000);
}

// Resend 60-second cooldown timer
function startResendCooldown(seconds) {
    clearInterval(resendCooldownInterval);
    resendSecondsRemaining = seconds;
    const btn = document.getElementById('resendOtpBtn');
    btn.disabled = true;

    const updateBtn = () => {
        btn.textContent = `Resend in ${resendSecondsRemaining}s`;
    };
    updateBtn();

    resendCooldownInterval = setInterval(() => {
        resendSecondsRemaining--;
        if (resendSecondsRemaining <= 0) {
            clearInterval(resendCooldownInterval);
            btn.disabled = false;
            btn.textContent = 'Resend Code';
        } else {
            updateBtn();
        }
    }, 1000);
}

// Setup OTP digit input handlers (auto-tab, backspace, paste)
function setupOtpInputs() {
    const inputs = Array.from(document.querySelectorAll('.otp-input'));

    inputs.forEach((input, idx) => {
        input.addEventListener('input', (e) => {
            const val = input.value.replace(/\D/g, '');
            input.value = val ? val[0] : '';
            if (input.value && idx < inputs.length - 1) {
                inputs[idx + 1].focus();
            }
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !input.value && idx > 0) {
                inputs[idx - 1].focus();
            }
        });

        input.addEventListener('paste', (e) => {
            e.preventDefault();
            const text = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '').slice(0, 6);
            if (text) {
                for (let i = 0; i < text.length; i++) {
                    if (inputs[i]) inputs[i].value = text[i];
                }
                const nextIdx = Math.min(text.length, inputs.length - 1);
                inputs[nextIdx].focus();
            }
        });
    });
}

function focusFirstOtp() {
    const inputs = document.querySelectorAll('.otp-input');
    if (inputs.length > 0) {
        inputs[0].focus();
        inputs[0].select();
    }
}

document.addEventListener('DOMContentLoaded', () => {
    setupOtpInputs();
});
</script>
</body>
</html>
