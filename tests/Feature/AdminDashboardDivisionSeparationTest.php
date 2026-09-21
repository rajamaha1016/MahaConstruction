<?php

namespace Tests\Feature;

use App\Models\ContactRequest;
use App\Models\PackageDetail;
use App\Models\Partner;
use App\Models\Project;
use App\Models\QuoteRequest;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardDivisionSeparationTest extends TestCase
{
    use RefreshDatabase;

    protected User $adminUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::create([
            'email'     => 'admin@mahaconstructions.com',
            'password'  => bcrypt('password123'),
            'full_name' => 'Maha Head Administrator',
            'role'      => 'admin',
            'is_active' => true,
        ]);
    }

    public function test_admin_dashboard_root_redirects_to_construction_dashboard(): void
    {
        $response = $this->withSession(['admin_authenticated' => true, 'admin_email' => $this->adminUser->email])
            ->get('/admin');

        $response->assertRedirect(route('admin.construction'));
    }

    public function test_construction_dashboard_displays_strictly_construction_records_and_common_tools(): void
    {
        // 1. Create construction records
        $cProj = Project::create([
            'name'          => 'Green Villa Alpha Construction',
            'location'      => 'Nagercoil',
            'business_type' => 'construction',
        ]);
        $cTest = Testimonial::create([
            'client_name'   => 'Mr. Raman Construction Client',
            'business_type' => 'construction',
        ]);
        $cPkg = PackageDetail::create([
            'division'      => 'residential',
            'tier'          => 'premium',
            'title'         => 'Structural Villa Build Tier',
            'business_type' => 'construction',
        ]);
        $cQuote = QuoteRequest::create([
            'name'          => 'Suresh Const Lead',
            'email'         => 'suresh@example.com',
            'phone'         => '9876543210',
            'project_type'  => 'Residential Villa',
            'business_type' => 'construction',
        ]);

        // 2. Create interior records
        $iProj = Project::create([
            'name'          => 'Luxury Penthouse Interior Fitout',
            'location'      => 'Kanyakumari',
            'business_type' => 'interior',
        ]);
        $iTest = Testimonial::create([
            'client_name'   => 'Dr. Ananya Interior Client',
            'business_type' => 'interior',
        ]);
        $iPkg = PackageDetail::create([
            'division'      => 'interior',
            'tier'          => 'luxury',
            'title'         => 'Italian Modular Kitchen Tier',
            'business_type' => 'interior',
        ]);
        $iQuote = QuoteRequest::create([
            'name'          => 'Deepa Interior Lead',
            'email'         => 'deepa@example.com',
            'phone'         => '9876543211',
            'project_type'  => 'Modular Interior Kitchen',
            'business_type' => 'interior',
        ]);

        // 3. Create shared common records
        $partner = Partner::create([
            'name'     => 'State Bank of India',
            'division' => 'banking',
        ]);

        // Request construction dashboard
        $response = $this->withSession(['admin_authenticated' => true, 'admin_email' => $this->adminUser->email])
            ->get('/admin/construction');

        $response->assertOk();

        // Must see construction items
        $response->assertSee('Green Villa Alpha Construction');
        $response->assertSee('Mr. Raman Construction Client');
        $response->assertSee('Structural Villa Build Tier');
        $response->assertSee('Suresh Const Lead');

        // Must NOT see interior items
        $response->assertDontSee('Luxury Penthouse Interior Fitout');
        $response->assertDontSee('Dr. Ananya Interior Client');
        $response->assertDontSee('Italian Modular Kitchen Tier');
        $response->assertDontSee('Deepa Interior Lead');

        // Must see common tools
        $response->assertSee('State Bank of India');
        $response->assertSee('Office &amp; Contact', false);
        $response->assertSee('Account Security');
        $response->assertSee('YouTube Channels');

        // Check workspace links
        $response->assertSee(route('admin.construction'), false);
        $response->assertSee(route('admin.interior'), false);
    }

    public function test_interior_dashboard_displays_strictly_interior_records_and_common_tools(): void
    {
        // 1. Create construction records
        $cProj = Project::create([
            'name'          => 'Green Villa Alpha Construction',
            'location'      => 'Nagercoil',
            'business_type' => 'construction',
        ]);
        $cTest = Testimonial::create([
            'client_name'   => 'Mr. Raman Construction Client',
            'business_type' => 'construction',
        ]);
        $cPkg = PackageDetail::create([
            'division'      => 'residential',
            'tier'          => 'premium',
            'title'         => 'Structural Villa Build Tier',
            'business_type' => 'construction',
        ]);
        $cQuote = QuoteRequest::create([
            'name'          => 'Suresh Const Lead',
            'email'         => 'suresh@example.com',
            'phone'         => '9876543210',
            'project_type'  => 'Residential Villa',
            'business_type' => 'construction',
        ]);

        // 2. Create interior records
        $iProj = Project::create([
            'name'          => 'Luxury Penthouse Interior Fitout',
            'location'      => 'Kanyakumari',
            'business_type' => 'interior',
        ]);
        $iTest = Testimonial::create([
            'client_name'   => 'Dr. Ananya Interior Client',
            'business_type' => 'interior',
        ]);
        $iPkg = PackageDetail::create([
            'division'      => 'interior',
            'tier'          => 'luxury',
            'title'         => 'Italian Modular Kitchen Tier',
            'business_type' => 'interior',
        ]);
        $iQuote = QuoteRequest::create([
            'name'          => 'Deepa Interior Lead',
            'email'         => 'deepa@example.com',
            'phone'         => '9876543211',
            'project_type'  => 'Modular Interior Kitchen',
            'business_type' => 'interior',
        ]);

        // 3. Create shared common records
        $partner = Partner::create([
            'name'     => 'HDFC Bank Loans',
            'division' => 'banking',
        ]);

        // Request interior dashboard
        $response = $this->withSession(['admin_authenticated' => true, 'admin_email' => $this->adminUser->email])
            ->get('/admin/interior');

        $response->assertOk();

        // Must see interior items
        $response->assertSee('Luxury Penthouse Interior Fitout');
        $response->assertSee('Dr. Ananya Interior Client');
        $response->assertSee('Italian Modular Kitchen Tier');
        $response->assertSee('Deepa Interior Lead');

        // Must NOT see construction items
        $response->assertDontSee('Green Villa Alpha Construction');
        $response->assertDontSee('Mr. Raman Construction Client');
        $response->assertDontSee('Structural Villa Build Tier');
        $response->assertDontSee('Suresh Const Lead');

        // Must NOT see packages comparison matrix (which is construction-specific)
        $response->assertDontSee('Packages Comparison Matrix Editor');

        // Must see common tools
        $response->assertSee('HDFC Bank Loans');
        $response->assertSee('Office &amp; Contact', false);
        $response->assertSee('Account Security');
        $response->assertSee('YouTube Channels');

        // Check workspace links
        $response->assertSee(route('admin.construction'), false);
        $response->assertSee(route('admin.interior'), false);
    }
}
