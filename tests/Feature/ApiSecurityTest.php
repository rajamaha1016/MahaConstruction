<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class ApiSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_reads_are_accessible_without_login(): void
    {
        $this->getJson('/api/projects')->assertOk();
        $this->getJson('/api/services')->assertOk();
        $this->getJson('/api/testimonials')->assertOk();
    }

    public function test_anonymous_visitors_can_submit_lead_forms(): void
    {
        $this->postJson('/api/leads/contact', [
            'name'    => 'Jane Doe',
            'email'   => 'jane@example.com',
            'message' => 'Interested in a quote.',
        ])->assertCreated();
    }

    #[DataProvider('mutatingEndpoints')]
    public function test_mutating_endpoints_reject_anonymous_requests(string $method, string $uri): void
    {
        $this->json($method, $uri, [])->assertStatus(401);
    }

    public static function mutatingEndpoints(): array
    {
        return [
            'create project'    => ['POST', '/api/projects'],
            'delete project'    => ['DELETE', '/api/projects/1'],
            'create service'    => ['POST', '/api/services'],
            'create gallery'    => ['POST', '/api/gallery'],
            'create blog'       => ['POST', '/api/blogs'],
            'create testimonial'=> ['POST', '/api/testimonials'],
            'save setting'          => ['POST', '/api/settings'],
            'save contact settings' => ['POST', '/api/settings/contact'],
            'read contact leads'    => ['GET', '/api/leads/contact'],
        ];
    }

    public function test_logged_in_admin_can_manage_content(): void
    {
        $admin = User::factory()->create([
            'password' => Hash::make('secret123'),
            'role'     => 'admin',
        ]);

        $this->actingAs($admin)
            ->withSession(['admin_authenticated' => true])
            ->postJson('/api/faqs', [
                'question' => 'Do you build villas?',
                'answer'   => 'Yes, that is our specialty.',
            ])->assertCreated();
    }
}
