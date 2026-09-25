<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        cache()->flush();
        config(['auth.admin_email' => 'mahaconstructions2013@gmail.com']);
    }

    protected function createAdmin(array $attributes = []): User
    {
        return User::create(array_merge([
            'email'     => config('auth.admin_email', 'mahaconstructions2013@gmail.com'),
            'password'  => Hash::make('CorrectPassword123!'),
            'full_name' => 'Er. Maha Rajan',
            'role'      => 'admin',
            'is_active' => true,
        ], $attributes));
    }

    public function test_admin_login_page_renders_successfully(): void
    {
        $response = $this->get('/admin/login');

        $response->assertOk();
        $response->assertSee('MAHA CONSTRUCTIONS');
        $response->assertSee('Admin Control Panel');
        $response->assertSee('SIGN IN TO ADMIN PANEL');
        $response->assertSee('Forgot Password?');
    }

    public function test_admin_login_succeeds_with_valid_credentials(): void
    {
        $admin = $this->createAdmin();

        $response = $this->post('/admin/login', [
            'email'    => $admin->email,
            'password' => 'CorrectPassword123!',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertTrue(session('admin_authenticated'));
        $this->assertEquals($admin->email, session('admin_email'));
        $this->assertEquals($admin->full_name, session('admin_name'));
    }

    public function test_admin_login_fails_with_invalid_credentials(): void
    {
        $admin = $this->createAdmin();

        $response = $this->from('/admin/login')->post('/admin/login', [
            'email'    => $admin->email,
            'password' => 'WrongPassword',
        ]);

        $response->assertRedirect('/admin/login');
        $response->assertSessionHasErrors('email');
        $this->assertFalse((bool) session('admin_authenticated'));
    }

    public function test_admin_login_fails_for_inactive_admin(): void
    {
        $admin = $this->createAdmin(['is_active' => false]);

        $response = $this->from('/admin/login')->post('/admin/login', [
            'email'    => $admin->email,
            'password' => 'CorrectPassword123!',
        ]);

        $response->assertRedirect('/admin/login');
        $response->assertSessionHasErrors('email');
        $this->assertFalse((bool) session('admin_authenticated'));
    }

    public function test_admin_login_fails_for_non_admin_role(): void
    {
        User::create([
            'email'     => 'editor@mahaconstruction.com',
            'password'  => Hash::make('CorrectPassword123!'),
            'full_name' => 'Site Editor',
            'role'      => 'editor',
            'is_active' => true,
        ]);

        $response = $this->from('/admin/login')->post('/admin/login', [
            'email'    => 'editor@mahaconstruction.com',
            'password' => 'CorrectPassword123!',
        ]);

        $response->assertRedirect('/admin/login');
        $response->assertSessionHasErrors('email');
        $this->assertFalse((bool) session('admin_authenticated'));
    }

    public function test_admin_logout_invalidates_session(): void
    {
        $admin = $this->createAdmin();

        // Login first
        $this->post('/admin/login', [
            'email'    => $admin->email,
            'password' => 'CorrectPassword123!',
        ]);

        $this->assertTrue(session('admin_authenticated'));

        // Logout
        $logoutResponse = $this->post('/admin/logout');
        $logoutResponse->assertRedirect(route('admin.login'));
        $this->assertFalse((bool) session('admin_authenticated'));

        // Dashboard is now protected
        $this->get('/admin')->assertRedirect(route('admin.login'));
    }

    protected function createChallenge(User $admin, string $plainOtp = '123456', array $attributes = []): \App\Models\PasswordResetChallenge
    {
        return \App\Models\PasswordResetChallenge::create(array_merge([
            'admin_user_id' => $admin->id,
            'otp_hash'      => Hash::make($plainOtp),
            'expires_at'    => now()->addMinutes(10),
            'attempt_count' => 0,
            'max_attempts'  => 5,
            'last_sent_at'  => now(),
            'request_ip'    => '127.0.0.1',
        ], $attributes));
    }

    public function test_forgot_password_rejects_unauthorized_or_non_official_emails(): void
    {
        $admin = $this->createAdmin();

        User::create([
            'email'     => 'editor@mahaconstruction.com',
            'password'  => Hash::make('EditorPass123!'),
            'role'      => 'editor',
            'is_active' => true,
        ]);

        User::create([
            'email'     => 'inactive@mahaconstruction.com',
            'password'  => Hash::make('InactivePass123!'),
            'role'      => 'admin',
            'is_active' => false,
        ]);

        $invalidMessage = 'Invalid email address. Please enter the valid admin email to reset your password.';

        // 1. Non-existent email
        $res1 = $this->postJson('/api/auth/forgot-password', ['email' => 'nobody@example.com']);
        $res1->assertStatus(422)->assertJson(['message' => $invalidMessage]);
        $this->assertEquals(0, \App\Models\PasswordResetChallenge::count());

        // 2. Non-admin email
        $res2 = $this->postJson('/api/auth/forgot-password', ['email' => 'editor@mahaconstruction.com']);
        $res2->assertStatus(422)->assertJson(['message' => $invalidMessage]);
        $this->assertEquals(0, \App\Models\PasswordResetChallenge::count());

        // 3. Inactive admin email
        $res3 = $this->postJson('/api/auth/forgot-password', ['email' => 'inactive@mahaconstruction.com']);
        $res3->assertStatus(422)->assertJson(['message' => $invalidMessage]);
        $this->assertEquals(0, \App\Models\PasswordResetChallenge::count());

        // 4. Other admin email not matching official configured admin email
        $otherAdmin = User::create([
            'email'     => 'otheradmin@mahaconstruction.com',
            'password'  => Hash::make('AdminPass123!'),
            'role'      => 'admin',
            'is_active' => true,
        ]);
        $resOtherAdmin = $this->postJson('/api/auth/forgot-password', ['email' => 'otheradmin@mahaconstruction.com']);
        $resOtherAdmin->assertStatus(422)->assertJson(['message' => $invalidMessage]);
        $this->assertEquals(0, \App\Models\PasswordResetChallenge::where('admin_user_id', $otherAdmin->id)->count());

        // 5. Official active admin email
        $resOfficial = $this->postJson('/api/auth/forgot-password', ['email' => $admin->email]);
        $resOfficial->assertOk()->assertJson(['success' => true]);

        $challenge = \App\Models\PasswordResetChallenge::where('admin_user_id', $admin->id)->latest('id')->first();
        $this->assertNotNull($challenge);
        $this->assertNotNull($challenge->otp_hash);
        // OTP must be hashed, not plaintext
        $this->assertNotEquals('123456', $challenge->otp_hash);
        $this->assertTrue($challenge->expires_at->isFuture());
    }

    public function test_only_official_configured_admin_email_can_request_password_reset(): void
    {
        $officialAdmin = $this->createAdmin();

        $rogueAdmin = User::create([
            'email'     => 'rogueadmin@example.com',
            'password'  => Hash::make('AdminPass123!'),
            'role'      => 'admin',
            'is_active' => true,
        ]);

        $invalidMessage = 'Invalid email address. Please enter the valid admin email to reset your password.';

        // Rogue admin attempt is rejected and generates NO challenge in DB
        $this->postJson('/api/auth/forgot-password', ['email' => $rogueAdmin->email])
            ->assertStatus(422)
            ->assertJson(['message' => $invalidMessage]);
        $this->assertEquals(0, \App\Models\PasswordResetChallenge::where('admin_user_id', $rogueAdmin->id)->count());

        // Official admin attempt succeeds AND generates valid challenge
        $this->postJson('/api/auth/forgot-password', ['email' => $officialAdmin->email])
            ->assertOk()
            ->assertJson(['success' => true]);
        $this->assertEquals(1, \App\Models\PasswordResetChallenge::where('admin_user_id', $officialAdmin->id)->count());
    }

    public function test_verify_otp_endpoint_validates_correctly_and_issues_reset_token(): void
    {
        $admin = $this->createAdmin();
        $challenge = $this->createChallenge($admin, '123456');

        // 1. Wrong email
        $resWrongEmail = $this->postJson('/api/auth/verify-otp', [
            'email' => 'wrong@example.com',
            'otp'   => '123456',
        ]);
        $resWrongEmail->assertStatus(422);

        // 2. Expired OTP
        $challenge->update(['expires_at' => now()->subMinute()]);
        $resExpired = $this->postJson('/api/auth/verify-otp', [
            'email' => $admin->email,
            'otp'   => '123456',
        ]);
        $resExpired->assertStatus(400);

        // Reset expiry for next steps
        $challenge->update(['expires_at' => now()->addMinutes(10)]);

        // 3. Incorrect OTP
        $resWrong = $this->postJson('/api/auth/verify-otp', [
            'email' => $admin->email,
            'otp'   => '999999',
        ]);
        $resWrong->assertStatus(400);
        $challenge->refresh();
        $this->assertEquals(1, $challenge->attempt_count);

        // 4. Correct OTP
        $resCorrect = $this->postJson('/api/auth/verify-otp', [
            'email' => $admin->email,
            'otp'   => '123456',
        ]);
        $resCorrect->assertOk()->assertJson(['success' => true]);
        $resetToken = $resCorrect->json('reset_token');
        $this->assertNotEmpty($resetToken);
        $this->assertEquals(64, strlen($resetToken));

        // OTP is marked used and reset token hash is stored in database
        $challenge->refresh();
        $this->assertNotNull($challenge->used_at);
        $this->assertNotNull($challenge->reset_token_hash);
        $this->assertEquals(hash('sha256', $resetToken), $challenge->reset_token_hash);
    }

    public function test_otp_cannot_be_reused_once_verified(): void
    {
        $admin = $this->createAdmin();
        $this->createChallenge($admin, '123456');

        // First verification succeeds
        $res1 = $this->postJson('/api/auth/verify-otp', [
            'email' => $admin->email,
            'otp'   => '123456',
        ]);
        $res1->assertOk();

        // Second verification with the same OTP fails (single-use)
        $res2 = $this->postJson('/api/auth/verify-otp', [
            'email' => $admin->email,
            'otp'   => '123456',
        ]);
        $res2->assertStatus(400);
    }

    public function test_verify_otp_enforces_lockout_after_max_failed_attempts(): void
    {
        $this->withoutMiddleware(\Illuminate\Routing\Middleware\ThrottleRequests::class);
        $admin = $this->createAdmin();
        $challenge = $this->createChallenge($admin, '123456');

        for ($i = 1; $i <= 5; $i++) {
            $res = $this->postJson('/api/auth/verify-otp', [
                'email' => $admin->email,
                'otp'   => '000000',
            ]);
            if ($i < 5) {
                $res->assertStatus(400);
            } else {
                $res->assertStatus(429);
            }
        }

        // Challenge must be marked used/locked out in DB
        $challenge->refresh();
        $this->assertNotNull($challenge->used_at);
        $this->assertEquals(5, $challenge->attempt_count);

        // Even with the real OTP, it is rejected because of lockout
        $this->postJson('/api/auth/verify-otp', [
            'email' => $admin->email,
            'otp'   => '123456',
        ])->assertStatus(400);
    }

    public function test_rate_limiting_on_auth_endpoints(): void
    {
        cache()->flush();
        $admin = $this->createAdmin();

        // 5 requests allowed, 6th must return 429
        for ($i = 1; $i <= 5; $i++) {
            $this->postJson('/api/auth/forgot-password', ['email' => 'wrong@example.com']);
        }

        $res6 = $this->postJson('/api/auth/forgot-password', ['email' => 'wrong@example.com']);
        $res6->assertStatus(429);
    }

    public function test_resend_otp_invalidates_previous_otp_and_enforces_cooldown(): void
    {
        $admin = $this->createAdmin();

        // 1. Initial request
        $res1 = $this->postJson('/api/auth/forgot-password', ['email' => $admin->email]);
        $res1->assertOk();
        $firstChallenge = \App\Models\PasswordResetChallenge::where('admin_user_id', $admin->id)->first();
        $this->assertNotNull($firstChallenge);

        // 2. Immediate resend before cooldown -> 429
        $resCooldown = $this->postJson('/api/auth/resend-reset-otp', ['email' => $admin->email]);
        $resCooldown->assertStatus(429);

        // 3. Simulate cooldown passing (65s later)
        $firstChallenge->update(['last_sent_at' => now()->subSeconds(65)]);

        // 4. Resend succeeds
        $res2 = $this->postJson('/api/auth/resend-reset-otp', ['email' => $admin->email]);
        $res2->assertOk();

        // Previous challenge must be marked used/invalidated
        $firstChallenge->refresh();
        $this->assertNotNull($firstChallenge->used_at);

        $secondChallenge = \App\Models\PasswordResetChallenge::where('admin_user_id', $admin->id)->latest('id')->first();
        $this->assertNotEquals($firstChallenge->id, $secondChallenge->id);
        $this->assertNull($secondChallenge->used_at);
    }

    public function test_reset_password_validates_reset_authorization_expiry_and_reuse(): void
    {
        $admin = $this->createAdmin();
        $plainToken = \Illuminate\Support\Str::random(64);

        $challenge = $this->createChallenge($admin, '123456', [
            'used_at'                => now(),
            'reset_token_hash'       => hash('sha256', $plainToken),
            'reset_token_expires_at' => now()->addMinutes(10),
            'reset_token_used_at'    => null,
        ]);

        // 1. Password mismatch -> 422
        $resMismatch = $this->postJson('/api/auth/reset-password', [
            'email'                     => $admin->email,
            'reset_token'               => $plainToken,
            'new_password'              => 'BrandNewPassword123!',
            'new_password_confirmation' => 'MismatchPassword123!',
        ]);
        $resMismatch->assertStatus(422);

        // 2. Too short (< 12 chars) -> 422
        $resShort = $this->postJson('/api/auth/reset-password', [
            'email'                     => $admin->email,
            'reset_token'               => $plainToken,
            'new_password'              => 'Short123!',
            'new_password_confirmation' => 'Short123!',
        ]);
        $resShort->assertStatus(422);

        // 3. Expired reset authorization -> 400
        $challenge->update(['reset_token_expires_at' => now()->subMinute()]);
        $resExpired = $this->postJson('/api/auth/reset-password', [
            'email'                     => $admin->email,
            'reset_token'               => $plainToken,
            'new_password'              => 'BrandNewPassword123!',
            'new_password_confirmation' => 'BrandNewPassword123!',
        ]);
        $resExpired->assertStatus(400);

        // Restore expiry
        $challenge->update(['reset_token_expires_at' => now()->addMinutes(10)]);

        // 4. Successful password reset
        $resSuccess = $this->postJson('/api/auth/reset-password', [
            'email'                     => $admin->email,
            'reset_token'               => $plainToken,
            'new_password'              => 'BrandNewPassword123!',
            'new_password_confirmation' => 'BrandNewPassword123!',
        ]);
        $resSuccess->assertOk()->assertJson(['message' => 'Password reset successfully. Please login using your new password.']);

        // Token is now marked used in database (single-use)
        $challenge->refresh();
        $this->assertNotNull($challenge->reset_token_used_at);

        // 5. Trying to reuse the same reset token fails -> 400
        $resReuse = $this->postJson('/api/auth/reset-password', [
            'email'                     => $admin->email,
            'reset_token'               => $plainToken,
            'new_password'              => 'AnotherPassword123!',
            'new_password_confirmation' => 'AnotherPassword123!',
        ]);
        $resReuse->assertStatus(400);
    }

    public function test_reset_password_revokes_sessions_and_tokens(): void
    {
        $admin = $this->createAdmin();
        $token = $admin->createToken('test-api-token')->plainTextToken;
        $this->assertEquals(1, $admin->tokens()->count());

        // Create active session record in database
        \Illuminate\Support\Facades\DB::table('sessions')->insert([
            'id'            => 'session_123',
            'user_id'       => $admin->id,
            'ip_address'    => '127.0.0.1',
            'user_agent'    => 'PHPUnit',
            'payload'       => 'test',
            'last_activity' => time(),
        ]);
        $this->assertEquals(1, \Illuminate\Support\Facades\DB::table('sessions')->where('user_id', $admin->id)->count());

        $plainToken = \Illuminate\Support\Str::random(64);
        $this->createChallenge($admin, '123456', [
            'used_at'                => now(),
            'reset_token_hash'       => hash('sha256', $plainToken),
            'reset_token_expires_at' => now()->addMinutes(10),
        ]);

        $this->postJson('/api/auth/reset-password', [
            'email'                     => $admin->email,
            'reset_token'               => $plainToken,
            'new_password'              => 'BrandNewPassword123!',
            'new_password_confirmation' => 'BrandNewPassword123!',
        ])->assertOk();

        // All API tokens for admin revoked
        $this->assertEquals(0, $admin->tokens()->count());

        // Database sessions deleted
        $this->assertEquals(0, \Illuminate\Support\Facades\DB::table('sessions')->where('user_id', $admin->id)->count());

        // Old password rejected
        \Illuminate\Support\Facades\RateLimiter::clear(\Illuminate\Support\Str::transliterate('127.0.0.1|admin.login.post'));
        $this->withoutMiddleware(\Illuminate\Routing\Middleware\ThrottleRequests::class);
        $oldLogin = $this->from('/admin/login')->post('/admin/login', [
            'email'    => $admin->email,
            'password' => 'CorrectPassword123!',
        ]);
        $oldLogin->assertSessionHasErrors('email');

        // New password works
        $newLogin = $this->post('/admin/login', [
            'email'    => $admin->email,
            'password' => 'BrandNewPassword123!',
        ]);
        $newLogin->assertRedirect(route('admin.dashboard'));
        $this->assertTrue(session('admin_authenticated'));
    }

    public function test_normal_users_and_unauthenticated_blocked_from_admin_apis(): void
    {
        // 1. Unauthenticated visitor blocked
        $this->getJson('/api/auth/me')->assertStatus(401);
        $this->get('/admin')->assertRedirect(route('admin.login'));
        $this->postJson('/api/testimonials', ['author_name' => 'Hacker'])->assertStatus(401);

        // 2. Authenticated normal user with non-admin role blocked
        $normalUser = User::create([
            'email'     => 'normal@example.com',
            'password'  => Hash::make('NormalPassword123!'),
            'role'      => 'editor',
            'is_active' => true,
        ]);

        $this->actingAs($normalUser);
        session(['admin_authenticated' => true, 'admin_email' => $normalUser->email]);

        // AdminAuthenticated middleware verifies role === 'admin' and blocks them
        $this->get('/admin')->assertRedirect(route('admin.login'));
        $this->postJson('/api/testimonials', ['author_name' => 'Hacker'])->assertStatus(403);
    }

    public function test_concurrent_otp_verification_atomic_consumption(): void
    {
        $admin = $this->createAdmin();
        $challenge = $this->createChallenge($admin, '123456');

        // Simulating atomic consumption:
        // Request A verifies OTP
        $resA = $this->postJson('/api/auth/verify-otp', [
            'email' => $admin->email,
            'otp'   => '123456',
        ]);
        $resA->assertOk();

        // Request B arrives simultaneously with the same OTP:
        // Because challenge->used_at was populated by Request A, Request B must be rejected
        $resB = $this->postJson('/api/auth/verify-otp', [
            'email' => $admin->email,
            'otp'   => '123456',
        ]);
        $resB->assertStatus(400);
    }

    public function test_end_to_end_user_experience_flow_from_prompt(): void
    {
        $this->withoutMiddleware(\Illuminate\Routing\Middleware\ThrottleRequests::class);
        $admin = $this->createAdmin();

        // 1. Open Admin Login: user should see Forgot Password
        $loginPage = $this->get('/admin/login');
        $loginPage->assertOk();
        $loginPage->assertSee('Forgot Password?');
        $loginPage->assertSee('Enter your admin email address');
        $loginPage->assertSee('SEND OTP');
        $loginPage->assertSee('Verify OTP');
        $loginPage->assertSee('Enter the 6-digit OTP sent to your registered email.');
        $loginPage->assertSee('Resend OTP');
        $loginPage->assertSee('Create New Password');

        // 2. Enter wrong email: confirm invalid-email message appears and no OTP sent
        $invalidEmailRes = $this->postJson('/api/auth/forgot-password', [
            'email' => 'test@gmail.com',
        ]);
        $invalidEmailRes->assertStatus(422)
            ->assertJson([
                'message' => 'Invalid email address. Please enter the valid admin email to reset your password.',
            ]);
        $this->assertEquals(0, \App\Models\PasswordResetChallenge::count());

        // 3. Enter valid admin email: confirm challenge is generated in DB
        $validEmailRes = $this->postJson('/api/auth/forgot-password', [
            'email' => 'mahaconstructions2013@gmail.com',
        ]);
        $validEmailRes->assertOk()->assertJson(['success' => true]);
        $firstChallenge = \App\Models\PasswordResetChallenge::where('admin_user_id', $admin->id)->first();
        $this->assertNotNull($firstChallenge);

        // 4. Enter wrong OTP: confirm rejected
        $wrongOtpRes = $this->postJson('/api/auth/verify-otp', [
            'email' => 'mahaconstructions2013@gmail.com',
            'otp'   => '000000',
        ]);
        $wrongOtpRes->assertStatus(400);

        // 5. Enter expired OTP: confirm rejected
        $firstChallenge->update(['expires_at' => now()->subMinute()]);
        $expiredOtpRes = $this->postJson('/api/auth/verify-otp', [
            'email' => 'mahaconstructions2013@gmail.com',
            'otp'   => '123456',
        ]);
        $expiredOtpRes->assertStatus(400);

        // 6. Resend OTP: simulate cooldown passed and request again
        $firstChallenge->update(['last_sent_at' => now()->subSeconds(65)]);
        $resendRes = $this->postJson('/api/auth/resend-reset-otp', [
            'email' => 'mahaconstructions2013@gmail.com',
        ]);
        $resendRes->assertOk();

        // Old challenge must be invalidated
        $firstChallenge->refresh();
        $this->assertNotNull($firstChallenge->used_at);

        $secondChallenge = \App\Models\PasswordResetChallenge::where('admin_user_id', $admin->id)->latest('id')->first();
        $this->assertNotNull($secondChallenge);

        // Set known OTP hash for verification
        $secondChallenge->update(['otp_hash' => Hash::make('654321')]);

        // 7. Verify with correct OTP -> returns reset_token
        $verifyRes = $this->postJson('/api/auth/verify-otp', [
            'email' => 'mahaconstructions2013@gmail.com',
            'otp'   => '654321',
        ]);
        $verifyRes->assertOk()->assertJson(['success' => true]);
        $resetToken = $verifyRes->json('reset_token');
        $this->assertNotEmpty($resetToken);

        // 8. Create new password: confirm password mismatch is rejected
        $mismatchRes = $this->postJson('/api/auth/reset-password', [
            'email'                     => 'mahaconstructions2013@gmail.com',
            'reset_token'               => $resetToken,
            'new_password'              => 'SuperSecurePass2026!',
            'new_password_confirmation' => 'MismatchPass2026!',
        ]);
        $mismatchRes->assertStatus(422);

        // 9. Create new password: confirm weak / short (<12 chars) password is rejected
        $shortRes = $this->postJson('/api/auth/reset-password', [
            'email'                     => 'mahaconstructions2013@gmail.com',
            'reset_token'               => $resetToken,
            'new_password'              => 'Short123!',
            'new_password_confirmation' => 'Short123!',
        ]);
        $shortRes->assertStatus(422);

        // 10. Reset successfully with valid >=12 character password
        $resetSuccessRes = $this->postJson('/api/auth/reset-password', [
            'email'                     => 'mahaconstructions2013@gmail.com',
            'reset_token'               => $resetToken,
            'new_password'              => 'SuperSecurePass2026!',
            'new_password_confirmation' => 'SuperSecurePass2026!',
        ]);
        $resetSuccessRes->assertOk()->assertJson([
            'message' => 'Password reset successfully. Please login using your new password.',
        ]);

        // 11. Confirm reset token is single-use and cannot be used again
        $this->postJson('/api/auth/reset-password', [
            'email'                     => 'mahaconstructions2013@gmail.com',
            'reset_token'               => $resetToken,
            'new_password'              => 'SuperSecurePass2026!',
            'new_password_confirmation' => 'SuperSecurePass2026!',
        ])->assertStatus(400);

        // 12. Confirm old password no longer works
        \Illuminate\Support\Facades\RateLimiter::clear(\Illuminate\Support\Str::transliterate('127.0.0.1|admin.login.post'));
        $this->withoutMiddleware(\Illuminate\Routing\Middleware\ThrottleRequests::class);
        $oldLogin = $this->from('/admin/login')->post('/admin/login', [
            'email'    => 'mahaconstructions2013@gmail.com',
            'password' => 'CorrectPassword123!',
        ]);
        $oldLogin->assertSessionHasErrors('email');
        $this->assertFalse((bool)session('admin_authenticated'));

        // 13. Confirm new password works
        $newLogin = $this->post('/admin/login', [
            'email'    => 'mahaconstructions2013@gmail.com',
            'password' => 'SuperSecurePass2026!',
        ]);
        $newLogin->assertRedirect(route('admin.dashboard'));
        $this->assertTrue(session('admin_authenticated'));

        // 14. Confirm unauthenticated visitors cannot access admin protected APIs and admin dashboard
        auth()->logout();
        session()->flush();
        $this->getJson('/api/auth/me')->assertStatus(401);
        $this->get('/admin')->assertRedirect(route('admin.login'));
    }
}
