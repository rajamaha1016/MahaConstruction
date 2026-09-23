<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ComprehensiveAuditTest extends TestCase
{
    use RefreshDatabase;

    private function createAdmin(): User
    {
        return User::factory()->create([
            'email'    => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role'     => 'admin',
        ]);
    }

    public function test_security_headers_are_applied_to_web_and_api(): void
    {
        $response = $this->get('/');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->assertHeader('Permissions-Policy');

        $apiResponse = $this->getJson('/api/projects');
        $apiResponse->assertHeader('X-Content-Type-Options', 'nosniff');
    }

    public function test_direct_upload_rejects_malicious_extensions(): void
    {
        $admin = $this->createAdmin();

        $file = UploadedFile::fake()->create('malicious.php', 10, 'application/x-php');

        $response = $this->actingAs($admin)
            ->withSession(['admin_authenticated' => true])
            ->postJson('/api/media/upload', [
                'file' => $file,
            ]);

        $response->assertStatus(422);
    }

    public function test_chunked_upload_rejects_disallowed_extension(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)
            ->withSession(['admin_authenticated' => true])
            ->postJson('/api/upload/finish', [
                'upload_id'    => 'test_session_123',
                'filename'     => 'exploit.php',
                'total_chunks' => 1,
            ]);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
            ]);
    }

    public function test_admin_login_rate_limiting(): void
    {
        // POST 5 failed login attempts
        for ($i = 0; $i < 5; $i++) {
            $this->post('/admin/login', [
                'email'    => 'attacker@example.com',
                'password' => 'wrongpass',
            ]);
        }

        // 6th attempt must be throttled
        $response = $this->post('/admin/login', [
            'email'    => 'attacker@example.com',
            'password' => 'wrongpass',
        ]);

        $response->assertStatus(429);
    }

    public function test_admin_endpoints_validate_payload_strictly(): void
    {
        $admin = $this->createAdmin();

        // 1. Partner requires name
        $partnerRes = $this->actingAs($admin)
            ->withSession(['admin_authenticated' => true])
            ->postJson('/api/partners', [
                'division' => 'banking',
            ]);
        $partnerRes->assertStatus(422)
            ->assertJsonValidationErrors(['name']);

        // 2. Package requires title and price_per_sqft
        $packageRes = $this->actingAs($admin)
            ->withSession(['admin_authenticated' => true])
            ->postJson('/api/packages', [
                'description' => 'Incomplete package',
            ]);
        $packageRes->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'price_per_sqft']);
    }

    public function test_settings_caching_and_cache_invalidation(): void
    {
        $admin = $this->createAdmin();

        // Pre-populate cache
        Cache::put('site_settings_cache', ['company_phone' => '1234567890'], 300);
        $this->assertTrue(Cache::has('site_settings_cache'));

        // Save new setting via admin endpoint
        $response = $this->actingAs($admin)
            ->withSession(['admin_authenticated' => true])
            ->postJson('/api/settings', [
                'key'   => 'company_phone',
                'value' => '+91 99999 88888',
            ]);

        $response->assertOk();

        // Cache must have been invalidated
        $this->assertFalse(Cache::has('site_settings_cache'));
    }
}
