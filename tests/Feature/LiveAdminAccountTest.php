<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LiveAdminAccountTest extends TestCase
{
    use RefreshDatabase;
    public function test_auth_admin_email_configuration(): void
    {
        $this->assertEquals('mahaconstructions2013@gmail.com', config('auth.admin_email'));
    }

    public function test_forgot_password_generates_otp_only_for_official_admin(): void
    {
        // Set up official admin in test database
        $admin = User::create([
            'email'     => 'mahaconstructions2013@gmail.com',
            'password'  => Hash::make('Maha@2013'),
            'role'      => 'admin',
            'is_active' => true,
        ]);

        $otherAdmin = User::create([
            'email'     => 'unauthorized@example.com',
            'password'  => Hash::make('Maha@2013'),
            'role'      => 'admin',
            'is_active' => true,
        ]);

        // Unauthorized admin: 422 with invalid email message, NO challenge in database
        $this->postJson('/api/auth/forgot-password', ['email' => $otherAdmin->email])
            ->assertStatus(422)
            ->assertJson(['message' => 'Invalid email address. Please enter the valid admin email to reset your password.']);
        $this->assertEquals(0, \App\Models\PasswordResetChallenge::where('admin_user_id', $otherAdmin->id)->count());

        // Official admin: success response, challenge created in database
        $this->postJson('/api/auth/forgot-password', ['email' => $admin->email])
            ->assertOk()
            ->assertJson(['success' => true]);
        $challenge = \App\Models\PasswordResetChallenge::where('admin_user_id', $admin->id)->latest('id')->first();
        $this->assertNotNull($challenge);
        $this->assertNotNull($challenge->otp_hash);
        $this->assertNotEquals('123456', $challenge->otp_hash);
    }

    public function test_admin_login_with_official_account(): void
    {
        $admin = User::create([
            'email'     => 'mahaconstructions2013@gmail.com',
            'password'  => Hash::make('Maha@2013'),
            'role'      => 'admin',
            'is_active' => true,
        ]);

        $response = $this->post('/admin/login', [
            'email'    => 'mahaconstructions2013@gmail.com',
            'password' => 'Maha@2013',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertTrue(session('admin_authenticated'));
        $this->assertEquals('mahaconstructions2013@gmail.com', session('admin_email'));
    }
}
