<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\PasswordResetChallenge;
use App\Mail\AdminPasswordResetMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminPasswordResetLinkTest extends TestCase
{
    use RefreshDatabase;

    protected function createOfficialAdmin(): User
    {
        return User::factory()->create([
            'email'     => 'mahaconstructions2013@gmail.com',
            'role'      => 'admin',
            'is_active' => true,
            'password'  => Hash::make('OldPassword123!'),
        ]);
    }

    public function test_valid_admin_requests_password_reset_and_email_contains_otp_and_button(): void
    {
        Mail::fake();

        $admin = $this->createOfficialAdmin();

        $response = $this->postJson('/api/auth/forgot-password', [
            'email' => $admin->email,
        ]);

        $response->assertOk()->assertJson([
            'success' => true,
            'message' => 'Verification code sent to your registered email address.'
        ]);

        $this->assertEquals(1, PasswordResetChallenge::where('admin_user_id', $admin->id)->count());
        $challenge = PasswordResetChallenge::where('admin_user_id', $admin->id)->latest('id')->first();
        $this->assertNotNull($challenge->reset_token_hash);
        $this->assertNotNull($challenge->reset_token_expires_at);

        Mail::assertSent(AdminPasswordResetMail::class, function (AdminPasswordResetMail $mail) use ($admin) {
            return $mail->hasTo($admin->email) &&
                   $mail->hasSubject('Admin Password Reset') &&
                   str_contains($mail->resetUrl, '/admin/reset-password/');
        });
    }

    public function test_local_request_generates_reset_url_pointing_to_local_application(): void
    {
        Mail::fake();

        $admin = $this->createOfficialAdmin();

        // Simulate local request coming into http://localhost:8000
        $response = $this->postJson('http://localhost:8000/api/auth/forgot-password', [
            'email' => $admin->email,
        ]);

        $response->assertOk();

        Mail::assertSent(AdminPasswordResetMail::class, function (AdminPasswordResetMail $mail) {
            return str_starts_with($mail->resetUrl, 'http://localhost:8000/admin/reset-password/') ||
                   str_starts_with($mail->resetUrl, 'http://localhost/admin/reset-password/');
        });
    }

    public function test_production_request_generates_reset_url_pointing_to_app_url(): void
    {
        Mail::fake();

        $admin = $this->createOfficialAdmin();

        // Simulate production request on Railway domain
        $response = $this->postJson('https://web-production-8d2af.up.railway.app/api/auth/forgot-password', [
            'email' => $admin->email,
        ]);

        $response->assertOk();

        $expectedPrefix = 'https://web-production-8d2af.up.railway.app/admin/reset-password/';
        Mail::assertSent(AdminPasswordResetMail::class, function (AdminPasswordResetMail $mail) use ($expectedPrefix) {
            return str_starts_with($mail->resetUrl, $expectedPrefix);
        });
    }

    public function test_email_rendering_contains_otp_button_and_correct_application_url(): void
    {
        $otp = '789123';
        $token = Str::random(64);
        $expectedUrl = config('app.url') . '/admin/reset-password/' . $token;

        $htmlView = view('emails.admin-password-reset', [
            'otp'      => $otp,
            'resetUrl' => $expectedUrl,
        ])->render();

        $textView = view('emails.admin-password-reset-text', [
            'otp'      => $otp,
            'resetUrl' => $expectedUrl,
        ])->render();

        // 1. Email contains OTP
        $this->assertStringContainsString('789123', $htmlView);
        $this->assertStringContainsString('789123', $textView);

        // 2. Email contains Reset Password button
        $this->assertStringContainsString('RESET PASSWORD', $htmlView);

        // 3. Reset Password URL points to correct application URL
        $this->assertStringContainsString($expectedUrl, $htmlView);
        $this->assertStringContainsString($expectedUrl, $textView);

        // 4. Contains 15 minutes notice and security warnings
        $this->assertStringContainsString('15 minutes', $htmlView);
        $this->assertStringContainsString('15 minutes', $textView);
        $this->assertStringContainsString('Maha Construction', $htmlView);
    }

    public function test_valid_reset_link_opens_password_reset_page(): void
    {
        $admin = $this->createOfficialAdmin();
        $plainToken = Str::random(64);

        PasswordResetChallenge::create([
            'admin_user_id'          => $admin->id,
            'otp_hash'               => Hash::make('123456'),
            'expires_at'             => now()->addMinutes(15),
            'attempt_count'          => 0,
            'max_attempts'           => 5,
            'last_sent_at'           => now(),
            'request_ip'             => '127.0.0.1',
            'reset_token_hash'       => hash('sha256', $plainToken),
            'reset_token_expires_at' => now()->addMinutes(15),
            'reset_token_used_at'    => null,
        ]);

        $response = $this->get('/admin/reset-password/' . $plainToken);

        $response->assertOk();
        $response->assertSee('Create New Password');
        $response->assertSee('RESET PASSWORD');
        $response->assertSee($admin->email);
    }

    public function test_invalid_token_is_rejected(): void
    {
        $this->createOfficialAdmin();

        $response = $this->get('/admin/reset-password/totally-invalid-token-123456');

        $response->assertStatus(400);
        $response->assertSee('This password reset link is invalid or has expired. Please request a new password reset.');
    }

    public function test_expired_token_is_rejected(): void
    {
        $admin = $this->createOfficialAdmin();
        $plainToken = Str::random(64);

        PasswordResetChallenge::create([
            'admin_user_id'          => $admin->id,
            'otp_hash'               => Hash::make('123456'),
            'expires_at'             => now()->subMinutes(5),
            'attempt_count'          => 0,
            'max_attempts'           => 5,
            'last_sent_at'           => now()->subMinutes(20),
            'request_ip'             => '127.0.0.1',
            'reset_token_hash'       => hash('sha256', $plainToken),
            'reset_token_expires_at' => now()->subMinutes(5),
            'reset_token_used_at'    => null,
        ]);

        $response = $this->get('/admin/reset-password/' . $plainToken);

        $response->assertStatus(400);
        $response->assertSee('This password reset link is invalid or has expired. Please request a new password reset.');
    }

    public function test_used_token_is_rejected(): void
    {
        $admin = $this->createOfficialAdmin();
        $plainToken = Str::random(64);

        PasswordResetChallenge::create([
            'admin_user_id'          => $admin->id,
            'otp_hash'               => Hash::make('123456'),
            'expires_at'             => now()->addMinutes(15),
            'attempt_count'          => 0,
            'max_attempts'           => 5,
            'last_sent_at'           => now(),
            'request_ip'             => '127.0.0.1',
            'reset_token_hash'       => hash('sha256', $plainToken),
            'reset_token_expires_at' => now()->addMinutes(15),
            'reset_token_used_at'    => now()->subMinutes(2),
        ]);

        $response = $this->get('/admin/reset-password/' . $plainToken);

        $response->assertStatus(400);
        $response->assertSee('This password reset link is invalid or has expired. Please request a new password reset.');
    }

    public function test_token_from_another_account_is_rejected(): void
    {
        // Rogue admin who is not the official client admin
        $rogueAdmin = User::factory()->create([
            'email'     => 'rogue@attacker.com',
            'role'      => 'admin',
            'is_active' => true,
        ]);

        $plainToken = Str::random(64);

        PasswordResetChallenge::create([
            'admin_user_id'          => $rogueAdmin->id,
            'otp_hash'               => Hash::make('123456'),
            'expires_at'             => now()->addMinutes(15),
            'attempt_count'          => 0,
            'max_attempts'           => 5,
            'last_sent_at'           => now(),
            'request_ip'             => '127.0.0.1',
            'reset_token_hash'       => hash('sha256', $plainToken),
            'reset_token_expires_at' => now()->addMinutes(15),
            'reset_token_used_at'    => null,
        ]);

        $response = $this->get('/admin/reset-password/' . $plainToken);

        $response->assertStatus(400);
        $response->assertSee('This password reset link is invalid or has expired. Please request a new password reset.');
    }

    public function test_password_length_validation_and_confirmation_rules(): void
    {
        $admin = $this->createOfficialAdmin();
        $plainToken = Str::random(64);

        $challenge = PasswordResetChallenge::create([
            'admin_user_id'          => $admin->id,
            'otp_hash'               => Hash::make('123456'),
            'expires_at'             => now()->addMinutes(15),
            'attempt_count'          => 0,
            'max_attempts'           => 5,
            'last_sent_at'           => now(),
            'request_ip'             => '127.0.0.1',
            'reset_token_hash'       => hash('sha256', $plainToken),
            'reset_token_expires_at' => now()->addMinutes(15),
            'reset_token_used_at'    => null,
        ]);

        // 1. Password with 5 characters is rejected
        $res5Chars = $this->postJson('/admin/reset-password', [
            'email'                     => $admin->email,
            'token'                     => $plainToken,
            'new_password'              => '12345',
            'new_password_confirmation' => '12345',
        ]);
        $res5Chars->assertStatus(422);
        $res5Chars->assertJsonValidationErrors(['new_password']);

        // 2. Password confirmation mismatch is rejected
        $resMismatch = $this->postJson('/admin/reset-password', [
            'email'                     => $admin->email,
            'token'                     => $plainToken,
            'new_password'              => '123456',
            'new_password_confirmation' => 'different678',
        ]);
        $resMismatch->assertStatus(422);
        $resMismatch->assertJsonValidationErrors(['new_password']);

        // 3. Password with 6 characters is accepted (e.g. 123456)
        $res6Chars = $this->postJson('/admin/reset-password', [
            'email'                     => $admin->email,
            'token'                     => $plainToken,
            'new_password'              => '123456',
            'new_password_confirmation' => '123456',
        ]);
        $res6Chars->assertOk()->assertJson([
            'success' => true,
            'message' => 'Password reset successfully. Please login using your new password.',
        ]);

        // Verify password updated in database
        $admin->refresh();
        $this->assertTrue(Hash::check('123456', $admin->password));
    }

    public function test_successful_reset_invalidates_token_revokes_sessions_and_updates_login(): void
    {
        $admin = $this->createOfficialAdmin();
        $plainToken = Str::random(64);

        $challenge = PasswordResetChallenge::create([
            'admin_user_id'          => $admin->id,
            'otp_hash'               => Hash::make('654321'),
            'expires_at'             => now()->addMinutes(15),
            'attempt_count'          => 0,
            'max_attempts'           => 5,
            'last_sent_at'           => now(),
            'request_ip'             => '127.0.0.1',
            'reset_token_hash'       => hash('sha256', $plainToken),
            'reset_token_expires_at' => now()->addMinutes(15),
            'reset_token_used_at'    => null,
        ]);

        // Create active Sanctum API token and session
        $admin->createToken('active-token');
        $this->assertEquals(1, $admin->tokens()->count());

        DB::table('sessions')->insert([
            'id'            => 'sess_test_123',
            'user_id'       => $admin->id,
            'ip_address'    => '127.0.0.1',
            'user_agent'    => 'TestBrowser',
            'payload'       => 'test_payload',
            'last_activity' => time(),
        ]);
        $this->assertEquals(1, DB::table('sessions')->where('user_id', $admin->id)->count());

        // Perform password reset with new password
        $response = $this->post('/admin/reset-password', [
            'email'                     => $admin->email,
            'reset_token'               => $plainToken,
            'new_password'              => 'NewSecurePass2026',
            'new_password_confirmation' => 'NewSecurePass2026',
        ]);

        // Form post redirects to admin login with flash success
        $response->assertRedirect(route('admin.login'));
        $response->assertSessionHas('success', 'Password reset successfully. Please login using your new password.');

        // Token and OTP marked used
        $challenge->refresh();
        $this->assertNotNull($challenge->reset_token_used_at);
        $this->assertNotNull($challenge->used_at);

        // Sanctum tokens revoked
        $this->assertEquals(0, $admin->tokens()->count());

        // Database sessions revoked
        $this->assertEquals(0, DB::table('sessions')->where('user_id', $admin->id)->count());

        // Token cannot be reused
        $reuseResponse = $this->postJson('/admin/reset-password', [
            'email'                     => $admin->email,
            'reset_token'               => $plainToken,
            'new_password'              => 'AnotherPass123',
            'new_password_confirmation' => 'AnotherPass123',
        ]);
        $reuseResponse->assertStatus(400);

        // OTP cannot be reused
        $otpReuse = $this->postJson('/api/auth/reset-password', [
            'email'                     => $admin->email,
            'otp'                       => '654321',
            'new_password'              => 'AnotherPass123',
            'new_password_confirmation' => 'AnotherPass123',
        ]);
        $otpReuse->assertStatus(400);

        // Old password no longer works
        $oldLogin = $this->post('/admin/login', [
            'email'    => $admin->email,
            'password' => 'OldPassword123!',
        ]);
        $oldLogin->assertSessionHasErrors(['email']);

        // New password works
        $newLogin = $this->post('/admin/login', [
            'email'    => $admin->email,
            'password' => 'NewSecurePass2026',
        ]);
        $newLogin->assertRedirect(route('admin.dashboard'));
        $this->assertTrue(session('admin_authenticated'));
        $this->assertEquals($admin->email, session('admin_email'));
    }

    public function test_wrong_email_does_not_generate_otp(): void
    {
        Mail::fake();

        $this->createOfficialAdmin();

        $response = $this->postJson('/api/auth/forgot-password', [
            'email' => 'wrongadmin@attacker.com',
        ]);

        $response->assertStatus(422);
        $this->assertEquals(0, PasswordResetChallenge::count());
        Mail::assertNothingSent();
    }
}
