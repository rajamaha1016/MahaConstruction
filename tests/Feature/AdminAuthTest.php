<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function createAdmin(array $attributes = []): User
    {
        return User::create(array_merge([
            'email'     => 'admin@mahaconstruction.com',
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
            'email'    => 'admin@mahaconstruction.com',
            'password' => 'CorrectPassword123!',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertTrue(session('admin_authenticated'));
        $this->assertEquals($admin->email, session('admin_email'));
        $this->assertEquals($admin->full_name, session('admin_name'));
    }

    public function test_admin_login_fails_with_invalid_credentials(): void
    {
        $this->createAdmin();

        $response = $this->from('/admin/login')->post('/admin/login', [
            'email'    => 'admin@mahaconstruction.com',
            'password' => 'WrongPassword',
        ]);

        $response->assertRedirect('/admin/login');
        $response->assertSessionHasErrors('email');
        $this->assertFalse((bool) session('admin_authenticated'));
    }

    public function test_admin_login_fails_for_inactive_admin(): void
    {
        $this->createAdmin(['is_active' => false]);

        $response = $this->from('/admin/login')->post('/admin/login', [
            'email'    => 'admin@mahaconstruction.com',
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
        $this->createAdmin();

        // Login first
        $this->post('/admin/login', [
            'email'    => 'admin@mahaconstruction.com',
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

    public function test_forgot_password_account_enumeration_protection(): void
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

        $expectedMessage = 'If that email is registered, an OTP has been sent to it.';

        // 1. Non-existent email
        $res1 = $this->postJson('/api/auth/forgot-password', ['email' => 'nobody@example.com']);
        $res1->assertOk()->assertJson(['message' => $expectedMessage]);
        $this->assertNull(cache()->get('otp_nobody@example.com'));

        // 2. Non-admin email
        $res2 = $this->postJson('/api/auth/forgot-password', ['email' => 'editor@mahaconstruction.com']);
        $res2->assertOk()->assertJson(['message' => $expectedMessage]);
        $this->assertNull(cache()->get('otp_editor@mahaconstruction.com'));

        // 3. Inactive admin email
        $res3 = $this->postJson('/api/auth/forgot-password', ['email' => 'inactive@mahaconstruction.com']);
        $res3->assertOk()->assertJson(['message' => $expectedMessage]);
        $this->assertNull(cache()->get('otp_inactive@mahaconstruction.com'));

        // 4. Active admin email
        $res4 = $this->postJson('/api/auth/forgot-password', ['email' => $admin->email]);
        $res4->assertOk()->assertJson(['message' => $expectedMessage]);

        $otp = cache()->get('otp_' . $admin->email);
        $this->assertNotNull($otp);
        $this->assertEquals(6, strlen((string) $otp));
        $this->assertMatchesRegularExpression('/^[0-9]{6}$/', (string) $otp);
    }

    public function test_reset_password_rejects_wrong_or_expired_otp(): void
    {
        $admin = $this->createAdmin();

        // Expired / missing OTP
        $resMissing = $this->postJson('/api/auth/reset-password', [
            'email'        => $admin->email,
            'otp'          => '999999',
            'new_password' => 'BrandNewPassword123!',
        ]);
        $resMissing->assertStatus(400);

        // Wrong OTP with active cache
        cache()->put('otp_' . $admin->email, '123456', 600);

        $resWrong = $this->postJson('/api/auth/reset-password', [
            'email'        => $admin->email,
            'otp'          => '654321',
            'new_password' => 'BrandNewPassword123!',
        ]);
        $resWrong->assertStatus(400);
    }

    public function test_reset_password_enforces_attempt_lockout(): void
    {
        $admin = $this->createAdmin();
        cache()->put('otp_' . $admin->email, '123456', 600);

        for ($i = 1; $i <= 5; $i++) {
            $this->postJson('/api/auth/reset-password', [
                'email'        => $admin->email,
                'otp'          => '000000',
                'new_password' => 'BrandNewPassword123!',
            ])->assertStatus(400);
        }

        // OTP should now be deleted from cache due to excessive failed attempts
        $this->assertNull(cache()->get('otp_' . $admin->email));

        // Even supplying the real OTP now fails because it was invalidated
        $this->postJson('/api/auth/reset-password', [
            'email'        => $admin->email,
            'otp'          => '123456',
            'new_password' => 'BrandNewPassword123!',
        ])->assertStatus(400);
    }

    public function test_reset_password_validates_password_rules(): void
    {
        $admin = $this->createAdmin();
        cache()->put('otp_' . $admin->email, '123456', 600);

        // Too short (< 8 chars)
        $resShort = $this->postJson('/api/auth/reset-password', [
            'email'        => $admin->email,
            'otp'          => '123456',
            'new_password' => 'short',
        ]);
        $resShort->assertStatus(422);

        // Confirmation mismatch
        $resMismatch = $this->postJson('/api/auth/reset-password', [
            'email'                     => $admin->email,
            'otp'                       => '123456',
            'new_password'              => 'BrandNewPassword123!',
            'new_password_confirmation' => 'DifferentPassword123!',
        ]);
        $resMismatch->assertStatus(422);
    }

    public function test_complete_forgot_and_reset_password_flow_and_subsequent_login(): void
    {
        $admin = $this->createAdmin();

        // 1. Request OTP
        $this->postJson('/api/auth/forgot-password', [
            'email' => $admin->email,
        ])->assertOk();

        $otp = cache()->get('otp_' . $admin->email);
        $this->assertNotNull($otp);

        // 2. Reset password
        $resetRes = $this->postJson('/api/auth/reset-password', [
            'email'                     => $admin->email,
            'otp'                       => (string) $otp,
            'new_password'              => 'NewSecurePass2026!',
            'new_password_confirmation' => 'NewSecurePass2026!',
        ]);
        $resetRes->assertOk()->assertJson(['message' => 'Password reset successfully.']);

        // 3. Verify OTP is invalidated (single-use)
        $this->assertNull(cache()->get('otp_' . $admin->email));

        // 4. Old password must now be rejected
        $this->from('/admin/login')->post('/admin/login', [
            'email'    => $admin->email,
            'password' => 'CorrectPassword123!',
        ])->assertSessionHasErrors('email');

        // 5. New password must successfully login
        $loginRes = $this->post('/admin/login', [
            'email'    => $admin->email,
            'password' => 'NewSecurePass2026!',
        ]);
        $loginRes->assertRedirect(route('admin.dashboard'));
        $this->assertTrue(session('admin_authenticated'));
        $this->assertEquals($admin->email, session('admin_email'));
    }
}
