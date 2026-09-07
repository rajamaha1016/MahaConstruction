<?php

namespace Tests\Feature;

use App\Models\ContactRequest;
use App\Models\QuoteRequest;
use App\Models\User;
use App\Models\WebsiteAnalytic;
use App\Services\AnalyticsService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AnalyticsTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticateAdmin(): User
    {
        $admin = User::factory()->create([
            'email' => 'admin@mahaconstructions.com',
            'role'  => 'admin',
        ]);

        $this->withSession([
            'admin_authenticated' => true,
            'admin_email'         => $admin->email,
            'admin_name'          => 'Maha Admin',
        ]);

        return $admin;
    }

    // 1. Analytics event can be recorded
    public function test_analytics_event_can_be_recorded(): void
    {
        $response = $this->postJson('/api/analytics/event', [
            'business_type' => 'construction',
            'event_type'    => 'page_view',
            'visitor_id'    => 'vid_test_123',
            'session_id'    => 'sid_test_456',
            'page_url'      => '/pricing',
            'page_name'     => 'pricing',
            'referrer'      => 'https://google.com',
            'device_type'   => 'desktop',
        ]);

        $response->assertCreated();
        $response->assertJson([
            'success' => true,
            'event'   => [
                'business_type' => 'construction',
                'event_type'    => 'page_view',
            ]
        ]);

        $this->assertDatabaseHas('website_analytics', [
            'business_type' => 'construction',
            'event_type'    => 'page_view',
            'visitor_id'    => 'vid_test_123',
            'session_id'    => 'sid_test_456',
            'referrer_host' => 'Google',
            'device_type'   => 'desktop',
        ]);
    }

    // 2. Invalid business_type is rejected
    public function test_invalid_business_type_is_rejected(): void
    {
        $response = $this->postJson('/api/analytics/event', [
            'business_type' => 'invalid_division',
            'event_type'    => 'page_view',
            'visitor_id'    => 'vid_test',
            'session_id'    => 'sid_test',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['business_type']);
        $this->assertDatabaseCount('website_analytics', 0);
    }

    // 3. Invalid event_type is rejected
    public function test_invalid_event_type_is_rejected(): void
    {
        $response = $this->postJson('/api/analytics/event', [
            'business_type' => 'interior',
            'event_type'    => 'unsupported_mouse_click',
            'visitor_id'    => 'vid_test',
            'session_id'    => 'sid_test',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['event_type']);
        $this->assertDatabaseCount('website_analytics', 0);
    }

    // 4. Construction analytics only returns construction data
    public function test_construction_analytics_only_returns_construction_data(): void
    {
        $this->authenticateAdmin();

        // Seed construction events
        WebsiteAnalytic::create([
            'business_type' => 'construction',
            'event_type'    => 'page_view',
            'visitor_id'    => 'vid_const_1',
            'session_id'    => 'sid_const_1',
            'page_name'     => 'home',
            'created_at'    => Carbon::now(),
        ]);

        // Seed interior events
        WebsiteAnalytic::create([
            'business_type' => 'interior',
            'event_type'    => 'page_view',
            'visitor_id'    => 'vid_int_1',
            'session_id'    => 'sid_int_1',
            'page_name'     => 'interior',
            'created_at'    => Carbon::now(),
        ]);

        // Query construction analytics
        $response = $this->getJson('/api/admin/analytics/overview?division=construction&period=30days');
        $response->assertOk();

        $data = $response->json();
        $this->assertEquals('construction', $data['division']);
        $this->assertEquals(1, $data['kpis']['visitors']);
        $this->assertEquals(1, $data['kpis']['page_views']);
    }

    // 5. Interior analytics only returns interior data
    public function test_interior_analytics_only_returns_interior_data(): void
    {
        $this->authenticateAdmin();

        WebsiteAnalytic::create([
            'business_type' => 'construction',
            'event_type'    => 'page_view',
            'visitor_id'    => 'vid_const_1',
            'session_id'    => 'sid_const_1',
            'created_at'    => Carbon::now(),
        ]);

        WebsiteAnalytic::create([
            'business_type' => 'interior',
            'event_type'    => 'page_view',
            'visitor_id'    => 'vid_int_1',
            'session_id'    => 'sid_int_1',
            'created_at'    => Carbon::now(),
        ]);

        WebsiteAnalytic::create([
            'business_type' => 'interior',
            'event_type'    => 'page_view',
            'visitor_id'    => 'vid_int_2',
            'session_id'    => 'sid_int_2',
            'created_at'    => Carbon::now(),
        ]);

        $response = $this->getJson('/api/admin/analytics/overview?division=interior&period=30days');
        $response->assertOk();

        $data = $response->json();
        $this->assertEquals('interior', $data['division']);
        $this->assertEquals(2, $data['kpis']['visitors']);
        $this->assertEquals(2, $data['kpis']['page_views']);
    }

    // 6. ALL analytics can combine both divisions
    public function test_all_analytics_combines_both_divisions(): void
    {
        $this->authenticateAdmin();

        WebsiteAnalytic::create([
            'business_type' => 'construction',
            'event_type'    => 'page_view',
            'visitor_id'    => 'vid_const_1',
            'session_id'    => 'sid_const_1',
            'created_at'    => Carbon::now(),
        ]);

        WebsiteAnalytic::create([
            'business_type' => 'interior',
            'event_type'    => 'page_view',
            'visitor_id'    => 'vid_int_1',
            'session_id'    => 'sid_int_1',
            'created_at'    => Carbon::now(),
        ]);

        $response = $this->getJson('/api/admin/analytics/overview?division=all&period=30days');
        $response->assertOk();

        $data = $response->json();
        $this->assertEquals('all', $data['division']);
        $this->assertEquals(2, $data['kpis']['visitors']);
        $this->assertEquals(2, $data['kpis']['page_views']);
    }

    // 7. Interior section views are tracked
    public function test_interior_section_views_are_tracked(): void
    {
        $this->authenticateAdmin();

        $service = app(AnalyticsService::class);
        $service->recordEvent([
            'business_type' => 'interior',
            'event_type'    => 'section_view',
            'section_name'  => 'services',
            'visitor_id'    => 'vid_int_sec',
            'session_id'    => 'sid_int_sec',
        ]);

        $this->assertDatabaseHas('website_analytics', [
            'business_type' => 'interior',
            'event_type'    => 'section_view',
            'section_name'  => 'services',
        ]);

        $overview = $service->getOverview('interior', '30days');
        $servicesSec = collect($overview['section_performance'])->firstWhere('section_id', 'services');
        $this->assertNotNull($servicesSec);
        $this->assertEquals(1, $servicesSec['views']);
    }

    // 8. Duplicate section events are prevented / controlled appropriately
    public function test_duplicate_section_events_handled_appropriately(): void
    {
        $this->authenticateAdmin();

        $service = app(AnalyticsService::class);

        // Same session records services section twice
        $service->recordEvent([
            'business_type' => 'interior',
            'event_type'    => 'section_view',
            'section_name'  => 'services',
            'visitor_id'    => 'vid_1',
            'session_id'    => 'sid_same_session',
        ]);
        $service->recordEvent([
            'business_type' => 'interior',
            'event_type'    => 'section_view',
            'section_name'  => 'services',
            'visitor_id'    => 'vid_1',
            'session_id'    => 'sid_same_session',
        ]);

        // Section performance groups by DISTINCT session_id
        $overview = $service->getOverview('interior', '30days');
        $servicesSec = collect($overview['section_performance'])->firstWhere('section_id', 'services');
        $this->assertNotNull($servicesSec);
        $this->assertEquals(1, $servicesSec['views']); // Only 1 unique session count
    }

    // 9. Successful Interior enquiry creates: business_type = interior and successful enquiry analytics
    public function test_successful_interior_enquiry_creates_interior_analytics_event(): void
    {
        $response = $this->postJson('/api/leads/interior/enquiry', [
            'name'         => 'Ananya Sundar',
            'email'        => 'ananya@example.com',
            'phone'        => '9876500001',
            'project_type' => 'Modular Kitchen',
            'message'      => 'Need premium modular kitchen installation',
            'visitor_id'   => 'vid_ananya',
            'session_id'   => 'sid_ananya',
            'utm_source'   => 'Instagram',
        ]);

        $response->assertCreated();

        // Verify lead creation
        $lead = QuoteRequest::where('phone', '9876500001')->first();
        $this->assertNotNull($lead);
        $this->assertEquals('interior', $lead->business_type);

        // Verify linked analytics creation
        $this->assertDatabaseHas('website_analytics', [
            'business_type' => 'interior',
            'event_type'    => 'enquiry_submitted',
            'lead_id'       => $lead->id,
            'lead_type'     => 'quote_request',
            'visitor_id'    => 'vid_ananya',
            'session_id'    => 'sid_ananya',
            'referrer_host' => 'Instagram',
        ]);
    }

    // 10. Failed Interior enquiry does NOT create a successful enquiry_submitted event
    public function test_failed_interior_enquiry_does_not_create_enquiry_submitted_event(): void
    {
        $response = $this->postJson('/api/leads/interior/enquiry', [
            // Missing required name and email
            'phone'   => '9876500002',
            'message' => 'Incomplete lead',
        ]);

        $response->assertStatus(422);

        $this->assertDatabaseMissing('quote_requests', [
            'phone' => '9876500002',
        ]);

        $this->assertDatabaseMissing('website_analytics', [
            'event_type' => 'enquiry_submitted',
        ]);
    }

    // 11. Construction enquiry creates: business_type = construction
    public function test_construction_enquiry_creates_construction_analytics_event(): void
    {
        // Quote lead
        $quoteRes = $this->postJson('/api/leads/quote', [
            'name'         => 'Ramanathan',
            'email'        => 'ramanathan@example.com',
            'phone'        => '9443300001',
            'project_type' => 'Residential Villa',
            'visitor_id'   => 'vid_ramanathan',
            'session_id'   => 'sid_ramanathan',
            'utm_source'   => 'Google',
        ]);
        $quoteRes->assertCreated();

        $constLead = QuoteRequest::where('phone', '9443300001')->first();
        $this->assertNotNull($constLead);
        $this->assertEquals('construction', $constLead->business_type);

        $this->assertDatabaseHas('website_analytics', [
            'business_type' => 'construction',
            'event_type'    => 'enquiry_submitted',
            'lead_id'       => $constLead->id,
            'visitor_id'    => 'vid_ramanathan',
        ]);

        // Contact lead
        $contactRes = $this->postJson('/api/leads/contact', [
            'name'       => 'Saravanan',
            'email'      => 'saravanan@example.com',
            'phone'      => '9443300002',
            'message'    => 'Commercial plot consultation',
            'visitor_id' => 'vid_saravanan',
            'session_id' => 'sid_saravanan',
        ]);
        $contactRes->assertCreated();

        $contactLead = ContactRequest::where('phone', '9443300002')->first();
        $this->assertNotNull($contactLead);
        $this->assertEquals('construction', $contactLead->business_type);

        $this->assertDatabaseHas('website_analytics', [
            'business_type' => 'construction',
            'event_type'    => 'contact_submitted',
            'lead_id'       => $contactLead->id,
        ]);
    }

    // 12. Conversion rate handles zero visitors safely
    public function test_conversion_rate_handles_zero_visitors_safely(): void
    {
        $this->authenticateAdmin();

        // No website_analytics records seeded (0 visitors)
        $service = app(AnalyticsService::class);
        $data = $service->getOverview('all', '30days');

        $this->assertEquals(0, $data['kpis']['conversion_rate']);
        $this->assertEquals(0, $data['division_comparison']['construction']['conversion_rate']);
        $this->assertEquals(0, $data['division_comparison']['interior']['conversion_rate']);

        $response = $this->getJson('/api/admin/analytics/overview?division=all&period=30days');
        $response->assertOk();
        $this->assertEquals(0, $response->json('kpis.conversion_rate'));
    }


    // 13. Unauthenticated users cannot access private admin analytics
    public function test_unauthenticated_users_cannot_access_private_admin_analytics(): void
    {
        $response = $this->getJson('/api/admin/analytics/overview');
        $response->assertStatus(401);
    }

    // 14. Existing Construction pages still work
    #[DataProvider('constructionPages')]
    public function test_existing_construction_pages_still_work(string $uri): void
    {
        $this->get($uri)->assertOk();
    }

    public static function constructionPages(): array
    {
        return [
            'home'         => ['/'],
            'projects'     => ['/projects'],
            'pricing'      => ['/pricing'],
            'testimonials' => ['/testimonials'],
        ];
    }

    // 15. Existing Interior single-page route still works
    public function test_existing_interior_single_page_route_still_works(): void
    {
        $response = $this->get('/interior');
        $response->assertOk();
        $response->assertSee('MAHA INTERIOR');
        $response->assertSee('id="interior-intro"', false);
        $response->assertSee('id="interior-enquiry"', false);
    }

    // 16. Prohibited Interior subroutes remain 404
    public function test_prohibited_interior_subroutes_remain_404(): void
    {
        $this->get('/interior/projects')->assertNotFound();
        $this->get('/interior/services')->assertNotFound();
        $this->get('/interior/packages')->assertNotFound();
        $this->get('/interior/contact')->assertNotFound();
    }

    // 17. Existing lead data is not modified incorrectly
    public function test_existing_lead_data_is_not_modified_incorrectly(): void
    {
        $lead = QuoteRequest::create([
            'name'          => 'Existing Client',
            'email'         => 'existing@example.com',
            'phone'         => '9800011122',
            'project_type'  => 'Residential Building',
            'business_type' => 'construction',
        ]);

        $this->assertDatabaseHas('quote_requests', [
            'id'            => $lead->id,
            'name'          => 'Existing Client',
            'business_type' => 'construction',
        ]);
    }

    // 18. Existing Construction analytics are not polluted by Interior records
    public function test_existing_construction_analytics_are_not_polluted_by_interior_records(): void
    {
        $this->authenticateAdmin();

        // 3 Interior visitors
        for ($i = 1; $i <= 3; $i++) {
            WebsiteAnalytic::create([
                'business_type' => 'interior',
                'event_type'    => 'page_view',
                'visitor_id'    => "vid_int_{$i}",
                'session_id'    => "sid_int_{$i}",
                'created_at'    => Carbon::now(),
            ]);
        }

        // 1 Construction visitor
        WebsiteAnalytic::create([
            'business_type' => 'construction',
            'event_type'    => 'page_view',
            'visitor_id'    => 'vid_const_1',
            'session_id'    => 'sid_const_1',
            'created_at'    => Carbon::now(),
        ]);

        $service = app(AnalyticsService::class);
        $constOverview = $service->getOverview('construction', '30days');

        // Construction KPIs must strictly count ONLY construction data (1 visitor, NOT 4)
        $this->assertEquals(1, $constOverview['kpis']['visitors']);
        $this->assertEquals(1, $constOverview['kpis']['page_views']);
        $this->assertNotEquals(4, $constOverview['kpis']['visitors']);

        // In the comparative strip, each division's metrics remain isolated
        $this->assertEquals(1, $constOverview['division_comparison']['construction']['visitors']);
        $this->assertEquals(3, $constOverview['division_comparison']['interior']['visitors']);
    }
}

