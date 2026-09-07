<?php

namespace Tests\Feature;

use App\Models\ContactRequest;
use App\Models\PackageDetail;
use App\Models\Project;
use App\Models\QuoteRequest;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class InteriorDataIsolationTest extends TestCase
{
    use RefreshDatabase;

    public function test_interior_page_returns_200_and_contains_exact_7_sections(): void
    {
        $response = $this->get('/interior');
        $response->assertOk();

        // Brand and title
        $response->assertSee('MAHA INTERIOR');

        // Verify the exact 7 section IDs
        $response->assertSee('id="interior-intro"', false);
        $response->assertSee('id="interior-services"', false);
        $response->assertSee('id="interior-projects"', false);
        $response->assertSee('id="interior-testimonials"', false);
        $response->assertSee('id="interior-engineer"', false);
        $response->assertSee('id="interior-packages"', false);
        $response->assertSee('id="interior-enquiry"', false);

        // Header and Footer links between divisions
        $response->assertSee('CONSTRUCTION');
        $response->assertSee(route('home'), false);
    }

    #[DataProvider('prohibitedInteriorRoutes')]
    public function test_prohibited_interior_subroutes_return_404(string $uri): void
    {
        $this->get($uri)->assertNotFound();
    }

    public static function prohibitedInteriorRoutes(): array
    {
        return [
            'interior_projects'     => ['/interior/projects'],
            'interior_services'     => ['/interior/services'],
            'interior_testimonials' => ['/interior/testimonials'],
            'interior_packages'     => ['/interior/packages'],
            'interior_engineer'     => ['/interior/engineer'],
            'interior_contact'      => ['/interior/contact'],
            'interior_about'        => ['/interior/about'],
            'interior_gallery'      => ['/interior/gallery'],
        ];
    }

    public function test_strict_data_isolation_between_construction_and_interior(): void
    {
        // Create distinct records for construction
        $constProject = Project::create([
            'name' => 'Const Villa Alpha',
            'business_type' => 'construction',
        ]);
        $constTestimonial = Testimonial::create([
            'client_name' => 'Mr. Const Owner',
            'business_type' => 'construction',
        ]);
        $constPackage = PackageDetail::create([
            'division' => 'residential',
            'tier' => 'standard',
            'title' => 'Const Standard Package',
            'business_type' => 'construction',
        ]);
        $constService = Service::create([
            'name' => 'Const Civil Works',
            'slug' => 'const-civil-works',
            'business_type' => 'construction',
        ]);

        // Create distinct records for interior
        $intProject = Project::create([
            'name' => 'Interior Penthouse Beta',
            'business_type' => 'interior',
        ]);
        $intTestimonial = Testimonial::create([
            'client_name' => 'Dr. Interior Client',
            'business_type' => 'interior',
        ]);
        $intPackage = PackageDetail::create([
            'division' => 'residential',
            'tier' => 'luxury',
            'title' => 'Interior Royal Living Package',
            'business_type' => 'interior',
        ]);
        $intService = Service::create([
            'name' => 'Interior Modular Wardrobes',
            'slug' => 'interior-modular-wardrobes',
            'business_type' => 'interior',
        ]);

        // 1. Visit / (Construction Home)
        $homeRes = $this->get('/');
        $homeRes->assertOk();
        $homeRes->assertSee('Const Villa Alpha');
        $homeRes->assertDontSee('Interior Penthouse Beta');

        // 2. Visit /projects (Construction Projects)
        $projRes = $this->get('/projects');
        $projRes->assertOk();
        $projRes->assertSee('Const Villa Alpha');
        $projRes->assertDontSee('Interior Penthouse Beta');

        // 3. Visit /testimonials (Construction Testimonials)
        $testRes = $this->get('/testimonials');
        $testRes->assertOk();
        $testRes->assertSee('Mr. Const Owner');
        $testRes->assertDontSee('Dr. Interior Client');

        // 4. Visit /pricing (Construction Pricing)
        $priceRes = $this->get('/pricing');
        $priceRes->assertOk();
        $priceRes->assertSee('CONST STANDARD PACKAGE');
        $priceRes->assertDontSee('Interior Royal Living Package');

        // 5. Visit /interior (Interior Single Showcase Page)
        $intRes = $this->get('/interior');
        $intRes->assertOk();
        $intRes->assertSee('Interior Penthouse Beta');
        $intRes->assertSee('Dr. Interior Client');
        $intRes->assertSee('Interior Royal Living Package');
        $intRes->assertSee('Interior Modular Wardrobes');

        $intRes->assertDontSee('Const Villa Alpha');
        $intRes->assertDontSee('Mr. Const Owner');
        $intRes->assertDontSee('CONST STANDARD PACKAGE');
        $intRes->assertDontSee('Const Civil Works');
    }

    public function test_server_enforces_business_type_on_leads_tamper_proof(): void
    {
        // 1. Interior consultation form: server forces business_type = 'interior'
        $intResponse = $this->postJson('/api/leads/interior/enquiry', [
            'name' => 'Priya Sharma',
            'phone' => '9876543210',
            'email' => 'priya@example.com',
            'city' => 'Nagercoil',
            'business_type' => 'construction', // Tamper attempt!
            'project_type' => 'Full Home Interior',
            'message' => 'Looking for luxury 3BHK interior execution'
        ]);
        $intResponse->assertCreated();

        $intLead = QuoteRequest::where('phone', '9876543210')->first();
        $this->assertNotNull($intLead);
        $this->assertEquals('interior', $intLead->business_type);

        // 2. Construction quote form: server forces business_type = 'construction'
        $quoteResponse = $this->postJson('/api/leads/quote', [
            'name' => 'Rajesh Kumar',
            'phone' => '9123456780',
            'email' => 'rajesh@example.com',
            'city' => 'Kanyakumari',
            'business_type' => 'interior', // Tamper attempt!
            'plot_size' => '2400',
            'project_type' => 'residential'
        ]);
        $quoteResponse->assertCreated();

        $constLead = QuoteRequest::where('phone', '9123456780')->first();
        $this->assertNotNull($constLead);
        $this->assertEquals('construction', $constLead->business_type);

        // 3. Contact request: server forces business_type = 'construction'
        $contactResponse = $this->postJson('/api/leads/contact', [
            'name' => 'Anand Raj',
            'phone' => '9988776655',
            'email' => 'anand@example.com',
            'business_type' => 'interior', // Tamper attempt!
            'message' => 'Need general civil consultation'
        ]);
        $contactResponse->assertCreated();

        $contactLead = ContactRequest::where('phone', '9988776655')->first();
        $this->assertNotNull($contactLead);
        $this->assertEquals('construction', $contactLead->business_type);
    }

    public function test_api_endpoints_filter_by_business_type(): void
    {
        Project::create(['name' => 'Const Villa', 'business_type' => 'construction']);
        Project::create(['name' => 'Interior Flat', 'business_type' => 'interior']);

        $resInterior = $this->getJson('/api/projects?business_type=interior');
        $resInterior->assertOk();
        $resInterior->assertJsonFragment(['name' => 'Interior Flat']);
        $resInterior->assertJsonMissing(['name' => 'Const Villa']);

        $resConst = $this->getJson('/api/projects?business_type=construction');
        $resConst->assertOk();
        $resConst->assertJsonFragment(['name' => 'Const Villa']);
        $resConst->assertJsonMissing(['name' => 'Interior Flat']);
    }
}
