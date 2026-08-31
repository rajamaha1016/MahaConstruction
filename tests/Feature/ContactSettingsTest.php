<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ContactSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_update_contact_settings_and_see_them_on_live_pages(): void
    {
        $admin = User::factory()->create([
            'password' => Hash::make('secret123'),
            'role'     => 'admin',
        ]);

        $payload = [
            'company_phone'           => '+91 99999 11111',
            'company_phone_secondary' => '+91 88888 22222',
            'company_whatsapp'        => '+91 77777 33333',
            'company_email'           => 'support@mahaconstructions.com',
            'company_hours'           => 'Mon-Fri: 9AM - 5PM',
            'company_branches'        => 'Madurai, Coimbatore, and Chennai',
            'company_address'         => 'Suite 404, Maha Heights, Main Road, Nagercoil',
        ];

        $response = $this->actingAs($admin)
            ->withSession(['admin_authenticated' => true])
            ->postJson('/api/settings/contact', $payload);

        $response->assertOk()
            ->assertJson(['success' => true]);

        // Verify database records
        $this->assertDatabaseHas('settings', ['key' => 'company_phone', 'value' => '+91 99999 11111']);
        $this->assertDatabaseHas('settings', ['key' => 'company_whatsapp', 'value' => '+91 77777 33333']);
        $this->assertDatabaseHas('settings', ['key' => 'company_email', 'value' => 'support@mahaconstructions.com']);
        $this->assertDatabaseHas('settings', ['key' => 'company_address', 'value' => 'Suite 404, Maha Heights, Main Road, Nagercoil']);

        // Verify live reflection on public contact page
        $contactPage = $this->get('/contact');
        $contactPage->assertOk();
        $contactPage->assertSee('Suite 404, Maha Heights, Main Road, Nagercoil');
        $contactPage->assertSee('+91 99999 11111');
        $contactPage->assertSee('support@mahaconstructions.com');
        $contactPage->assertSee('Mon-Fri: 9AM - 5PM');
        $contactPage->assertSee('wa.me/917777733333', false);

        // Verify live reflection on home page footer & badges
        $homePage = $this->get('/');
        $homePage->assertOk();
        $homePage->assertSee('Suite 404, Maha Heights, Main Road, Nagercoil');
        $homePage->assertSee('MADURAI, COIMBATORE, AND CHENNAI');
        $homePage->assertSee('wa.me/917777733333', false);
    }
}
