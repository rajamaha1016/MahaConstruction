<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrossNavigationBridgeTest extends TestCase
{
    use RefreshDatabase;
    public function test_construction_page_has_explore_maha_interior_bridge_after_site_tours(): void
    {
        $response = $this->get('/');
        $response->assertOk();

        $content = $response->getContent();

        // Must have the exact CTA button
        $response->assertSee('Explore MAHA Interior');
        $response->assertSee(route('interior'), false);

        // Must NOT have Explore MAHA Construction in the bridge
        $response->assertDontSee('Explore MAHA Construction');

        // Verify placement: youtube-sync-section appears before cross-nav-to-interior
        $ytPos = strpos($content, 'id="youtube-sync-section"');
        $bridgePos = strpos($content, 'id="cross-nav-to-interior"');

        $this->assertNotFalse($ytPos, 'youtube-sync-section must be present on Construction page');
        $this->assertNotFalse($bridgePos, 'cross-nav-to-interior must be present on Construction page');
        $this->assertGreaterThan($ytPos, $bridgePos, 'Cross-navigation bridge must be placed AFTER LEARN BEFORE YOU BUILD — SITE TOURS');
    }

    public function test_interior_page_has_explore_maha_construction_bridge_after_masterclasses(): void
    {
        $response = $this->get('/interior');
        $response->assertOk();

        $content = $response->getContent();

        // Must have the exact CTA button
        $response->assertSee('Explore MAHA Construction');
        $response->assertSee(route('home'), false);

        // Verify placement: interior-learn appears before cross-nav-to-construction
        $ytPos = strpos($content, 'id="interior-learn"');
        $bridgePos = strpos($content, 'id="cross-nav-to-construction"');

        $this->assertNotFalse($ytPos, 'interior-learn must be present on Interior page');
        $this->assertNotFalse($bridgePos, 'cross-nav-to-construction must be present on Interior page');
        $this->assertGreaterThan($ytPos, $bridgePos, 'Cross-navigation bridge must be placed AFTER 05 — YOUTUBE MASTERCLASSES & SITE TOURS');
    }
}
