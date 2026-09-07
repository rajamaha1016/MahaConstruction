<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Project;
use App\Models\BlogPost;
use App\Models\Testimonial;
use App\Models\FAQItem;
use App\Models\GalleryItem;
use App\Models\PackageDetail;
use App\Models\Partner;
use App\Models\Setting;
use App\Services\YouTubeSyncService;

class PageController extends Controller
{
    public function home(YouTubeSyncService $ytService)
    {
        $services       = Service::all();
        $projects       = Project::orderBy('id', 'desc')->take(12)->get();
        $testimonials   = Testimonial::orderBy('id', 'desc')->take(12)->get();
        $partners       = Partner::where('is_active', true)->get();
        $yt_channel_url = YouTubeSyncService::getActiveChannelUrl();
        $ytData         = $ytService->getVideos($yt_channel_url);
        $syncedVideos   = $ytData['videos'] ?? [];
        $channelMeta    = [
            'name'   => $ytData['channel_name'] ?? 'Maha Constructions',
            'url'    => $ytData['channel_url'] ?? $yt_channel_url,
            'avatar' => $ytData['channel_avatar'] ?? asset('logo.jpg'),
            'subs'   => $ytData['channel_subs'] ?? '',
            'count'  => $ytData['count'] ?? count($syncedVideos),
        ];
        $yt_channel_handle = YouTubeSyncService::getChannelHandle();
        $guidebook_pdf_url = Setting::where('key', 'guidebook_pdf_url')->value('value') ?: '/uploads/1785792673_new book.pdf';
        $intro_video_url   = Setting::where('key', 'intro_video_url')->value('value') ?: '/uploads/1785711422_WhatsApp Video 2026-07-30 at 10.50.53 AM.mp4';
        $residential       = PackageDetail::where('division', 'residential')->orderBy('price_per_sqft', 'asc')->get();
        $commercial        = PackageDetail::where('division', 'commercial')->orderBy('price_per_sqft', 'asc')->get();

        return view('home', compact(
            'services', 'projects', 'testimonials', 'partners', 'syncedVideos',
            'channelMeta', 'yt_channel_url', 'yt_channel_handle', 'guidebook_pdf_url',
            'intro_video_url', 'residential', 'commercial'
        ));
    }


    public function projects(Request $request)
    {
        $category = $request->get('category', 'all');
        $query    = Project::orderBy('id', 'desc');
        if ($category !== 'all') {
            $query->where('category', $category);
        }
        $projects = $query->get();
        return view('projects', compact('projects', 'category'));
    }

    public function testimonials()
    {
        $testimonials = Testimonial::orderBy('id', 'desc')->get();
        return view('testimonials', compact('testimonials'));
    }

    public function calculator()
    {
        return redirect()->route('pricing');
    }

    public function pricing()
    {
        $residential = PackageDetail::where('division', 'residential')->orderBy('price_per_sqft', 'asc')->get();
        $commercial  = PackageDetail::where('division', 'commercial')->orderBy('price_per_sqft', 'asc')->get();
        return view('pricing', compact('residential', 'commercial'));
    }

    public function notFound()
    {
        return response()->view('errors.404', [], 404);
    }
}
