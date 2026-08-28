<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider publicRoutes
     */
    public function test_public_page_loads(string $uri): void
    {
        $this->get($uri)->assertOk();
    }

    public static function publicRoutes(): array
    {
        return [
            'home'         => ['/'],
            'services'     => ['/services'],
            'projects'     => ['/projects'],
            'gallery'      => ['/gallery'],
            'testimonials' => ['/testimonials'],
            'calculator'   => ['/calculator'],
            'faq'          => ['/faq'],
            'contact'      => ['/contact'],
            'blog'         => ['/blog'],
            'pricing'      => ['/pricing'],
            'about'        => ['/about'],
            'careers'      => ['/careers'],
            'privacy'      => ['/privacy-policy'],
            'terms'        => ['/terms'],
        ];
    }

    public function test_admin_dashboard_redirects_anonymous_visitors_to_login(): void
    {
        $this->get('/admin')->assertRedirect(route('admin.login'));
    }
}
