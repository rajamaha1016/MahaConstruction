<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    #[DataProvider('publicRoutes')]
    public function test_public_page_loads(string $uri): void
    {
        $this->get($uri)->assertOk();
    }

    public static function publicRoutes(): array
    {
        return [
            'home'         => ['/'],
            'projects'     => ['/projects'],
            'testimonials' => ['/testimonials'],
            'pricing'      => ['/pricing'],
            'interior'     => ['/interior'],
        ];
    }

    #[DataProvider('deletedRoutes')]
    public function test_deleted_pages_return_404(string $uri): void
    {
        $this->get($uri)->assertNotFound();
    }

    public static function deletedRoutes(): array
    {
        return [
            'services'       => ['/services'],
            'gallery'        => ['/gallery'],
            'faq'            => ['/faq'],
            'contact'        => ['/contact'],
            'careers'        => ['/careers'],
            'privacy-policy' => ['/privacy-policy'],
            'terms'          => ['/terms'],
            'sitemap'        => ['/sitemap.xml'],
            'blog'           => ['/blog'],
            'about'          => ['/about'],
        ];
    }

    public function test_admin_dashboard_redirects_anonymous_visitors_to_login(): void
    {
        $this->get('/admin')->assertRedirect(route('admin.login'));
    }

    public function test_calculator_redirects_to_pricing(): void
    {
        $this->get('/calculator')->assertRedirect(route('pricing'));
    }
}
