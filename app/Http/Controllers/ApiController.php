<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Service;
use App\Models\GalleryItem;
use App\Models\BlogPost;
use App\Models\Testimonial;
use App\Models\FAQItem;
use App\Models\ContactRequest;
use App\Models\QuoteRequest;
use App\Models\Setting;
use App\Models\PackageDetail;
use App\Models\Partner;
use App\Models\NewsletterSubscriber;
use App\Models\GuidebookLead;
use App\Services\YouTubeSyncService;

class ApiController extends Controller
{
    // --- TESTIMONIALS ---
    public function getTestimonials()
    {
        return response()->json(Testimonial::orderBy('id', 'desc')->get());
    }

    public function createTestimonial(Request $request)
    {
        $data = $request->validate([
            'client_name'  => 'required|string',
            'client_role'  => 'nullable|string',
            'rating'       => 'nullable|integer',
            'feedback'     => 'nullable|string',
            'image_url'    => 'nullable|string',
            'video_url'    => 'nullable|string',
            'project_name' => 'nullable|string',
            'duration'     => 'nullable|string',
        ]);
        return response()->json(Testimonial::create($data), 201);
    }

    public function updateTestimonial(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->update($request->all());
        return response()->json($testimonial);
    }

    public function deleteTestimonial($id)
    {
        Testimonial::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    // --- PROJECTS ---
    public function getProjects()
    {
        return response()->json(Project::orderBy('id', 'desc')->get());
    }

    public function getProject($id)
    {
        return response()->json(Project::findOrFail($id));
    }

    public function createProject(Request $request)
    {
        $data = $request->validate([
            'name'               => 'required|string',
            'client'             => 'nullable|string',
            'location'           => 'nullable|string',
            'budget'             => 'nullable|string',
            'completion_date'    => 'nullable|string',
            'duration'           => 'nullable|string',
            'architecture_style' => 'nullable|string',
            'description'        => 'nullable|string',
            'image_urls'         => 'nullable|array',
            'video_url'          => 'nullable|string',
            'category'           => 'nullable|string',
            'is_featured'        => 'nullable|boolean',
        ]);
        return response()->json(Project::create($data), 201);
    }

    public function updateProject(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $project->update($request->all());
        return response()->json($project);
    }

    public function deleteProject($id)
    {
        Project::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    // --- SERVICES ---
    public function getServices()
    {
        return response()->json(Service::all());
    }

    public function getService($slug)
    {
        return response()->json(Service::where('slug', $slug)->firstOrFail());
    }

    public function createService(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|unique:services,name',
            'slug'     => 'required|string|unique:services,slug',
            'overview' => 'nullable|string',
            'benefits' => 'nullable|array',
            'process'  => 'nullable|array',
            'image_url'=> 'nullable|string',
            'category' => 'nullable|string',
        ]);
        return response()->json(Service::create($data), 201);
    }

    public function updateService(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $service->update($request->all());
        return response()->json($service);
    }

    public function deleteService($id)
    {
        Service::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    // --- GALLERY ---
    public function getGallery()
    {
        return response()->json(GalleryItem::orderBy('id', 'desc')->get());
    }

    public function createGallery(Request $request)
    {
        $data = $request->validate([
            'title'         => 'required|string',
            'category'      => 'required|string',
            'image_url'     => 'required|string',
            'is_video'      => 'nullable|boolean',
            'video_url'     => 'nullable|string',
            'three_sixty_url' => 'nullable|string',
        ]);
        return response()->json(GalleryItem::create($data), 201);
    }

    public function updateGallery(Request $request, $id)
    {
        $item = GalleryItem::findOrFail($id);
        $item->update($request->all());
        return response()->json($item);
    }

    public function deleteGallery($id)
    {
        GalleryItem::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    // --- BLOGS ---
    public function getBlogs()
    {
        return response()->json(BlogPost::orderBy('id', 'desc')->get());
    }

    public function getBlog($slug)
    {
        return response()->json(BlogPost::where('slug', $slug)->firstOrFail());
    }

    public function createBlog(Request $request)
    {
        $data = $request->validate([
            'title'    => 'required|string',
            'slug'     => 'required|string|unique:blogs,slug',
            'summary'  => 'nullable|string',
            'content'  => 'nullable|string',
            'author'   => 'nullable|string',
            'category' => 'nullable|string',
            'tags'     => 'nullable|string',
            'image_url'=> 'nullable|string',
        ]);
        return response()->json(BlogPost::create($data), 201);
    }

    public function updateBlog(Request $request, $id)
    {
        $blog = BlogPost::findOrFail($id);
        $blog->update($request->all());
        return response()->json($blog);
    }

    public function deleteBlog($id)
    {
        BlogPost::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    // --- FAQs ---
    public function getFaqs()
    {
        return response()->json(FAQItem::all());
    }

    public function createFaq(Request $request)
    {
        $data = $request->validate([
            'question' => 'required|string',
            'answer'   => 'required|string',
            'category' => 'nullable|string',
        ]);
        return response()->json(FAQItem::create($data), 201);
    }

    public function updateFaq(Request $request, $id)
    {
        $faq = FAQItem::findOrFail($id);
        $faq->update($request->all());
        return response()->json($faq);
    }

    public function deleteFaq($id)
    {
        FAQItem::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    // --- PACKAGES ---
    public function getPackages()
    {
        return response()->json(PackageDetail::all());
    }

    public function createPackage(Request $request)
    {
        return response()->json(PackageDetail::create($request->all()), 201);
    }

    public function updatePackage(Request $request, $id)
    {
        $pkg = PackageDetail::findOrFail($id);
        $pkg->update($request->all());
        return response()->json($pkg);
    }

    public function deletePackage($id)
    {
        PackageDetail::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    // --- PARTNERS ---
    public function getPartners()
    {
        return response()->json(Partner::where('is_active', true)->get());
    }

    public function createPartner(Request $request)
    {
        return response()->json(Partner::create($request->all()), 201);
    }

    public function updatePartner(Request $request, $id)
    {
        $partner = Partner::findOrFail($id);
        $partner->update($request->all());
        return response()->json($partner);
    }

    public function deletePartner($id)
    {
        Partner::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    // --- SETTINGS ---
    public function getSetting($key)
    {
        $setting = Setting::where('key', $key)->first();
        if (!$setting) return response()->json(['value' => null], 404);
        return response()->json($setting);
    }

    public function getSettings()
    {
        return response()->json(Setting::all());
    }

    public function saveSetting(Request $request)
    {
        $request->validate(['key' => 'required|string', 'value' => 'nullable|string']);
        $setting = Setting::updateOrCreate(['key' => $request->key], ['value' => $request->value]);
        return response()->json($setting);
    }

    // --- CONTACT / LEADS ---
    public function submitContact(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string',
            'email'   => 'required|email',
            'phone'   => 'nullable|string',
            'message' => 'required|string',
        ]);
        $contact = ContactRequest::create($data);
        return response()->json(['message' => 'Contact lead submitted successfully', 'lead' => $contact], 201);
    }

    public function getContacts()
    {
        return response()->json(ContactRequest::orderBy('id', 'desc')->get());
    }

    public function markContactRead($id)
    {
        $c = ContactRequest::findOrFail($id);
        $c->update(['is_read' => true]);
        return response()->json($c);
    }

    public function deleteContact($id)
    {
        ContactRequest::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted']);
    }

    public function submitQuote(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string',
            'email'        => 'required|email',
            'phone'        => 'nullable|string',
            'project_type' => 'required|string',
            'budget_range' => 'nullable|string',
            'message'      => 'nullable|string',
        ]);
        $quote = QuoteRequest::create($data);
        return response()->json(['message' => 'Quote request submitted', 'lead' => $quote], 201);
    }

    public function getQuotes()
    {
        return response()->json(QuoteRequest::orderBy('id', 'desc')->get());
    }

    public function markQuoteRead($id)
    {
        $q = QuoteRequest::findOrFail($id);
        $q->update(['is_read' => true]);
        return response()->json($q);
    }

    public function deleteQuote($id)
    {
        QuoteRequest::findOrFail($id)->delete();
        return response()->json(['message' => 'Deleted']);
    }

    // --- NEWSLETTER ---
    public function subscribeNewsletter(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $sub = NewsletterSubscriber::firstOrCreate(['email' => $request->email], ['is_active' => true]);
        return response()->json(['message' => 'Subscribed successfully', 'subscriber' => $sub], 201);
    }

    public function getNewsletterSubscribers()
    {
        return response()->json(NewsletterSubscriber::where('is_active', true)->get());
    }

    // --- YOUTUBE SYNC ---
    public function getYoutubeVideos(Request $request, YouTubeSyncService $syncService)
    {
        $targetUrl = $request->query('url') ?: YouTubeSyncService::getActiveChannelUrl();
        $force = $request->boolean('force');
        $result = $syncService->getVideos($targetUrl, $force);
        return response()->json($result);
    }

    public function syncYouTubeVideos(Request $request, YouTubeSyncService $syncService)
    {
        $targetUrl = $request->input('url') ?: YouTubeSyncService::getActiveChannelUrl();
        if ($request->filled('url')) {
            YouTubeSyncService::setActiveChannelUrl($targetUrl);
        }
        $result = $syncService->getVideos($targetUrl, true);
        return response()->json([
            'success' => $result['count'] > 0,
            'message' => $result['count'] > 0
                ? "Successfully synced {$result['count']} videos from {$result['channel_name']}!"
                : "No videos found for this channel URL. Please check the handle or URL.",
            'data'    => $result,
        ]);
    }

    public function saveYouTubeSettings(Request $request, YouTubeSyncService $syncService)
    {
        $request->validate([
            'channel_url' => 'nullable|string',
            'api_key'     => 'nullable|string',
        ]);

        if ($request->has('channel_url')) {
            YouTubeSyncService::setActiveChannelUrl($request->input('channel_url'));
        }

        if ($request->has('api_key')) {
            YouTubeSyncService::setApiKey($request->input('api_key'));
        }

        $targetUrl = YouTubeSyncService::getActiveChannelUrl();
        $result = $syncService->getVideos($targetUrl, true);

        return response()->json([
            'success' => $result['count'] > 0,
            'message' => $result['count'] > 0
                ? "YouTube settings saved! Synced {$result['count']} videos from {$result['channel_name']}."
                : 'Settings saved, but no videos could be fetched. Check the channel URL or try again later.',
            'data'    => $result,
        ]);
    }

    // --- STATS ---
    public function getStats()
    {
        return response()->json([
            'projects'               => Project::count(),
            'services'               => Service::count(),
            'testimonials'           => Testimonial::count(),
            'contacts'               => ContactRequest::count(),
            'quotes'                 => QuoteRequest::count(),
            'blogs'                  => BlogPost::count(),
            'gallery'                => GalleryItem::count(),
            'partners'               => Partner::count(),
            'newsletter'             => NewsletterSubscriber::where('is_active', true)->count(),
            'unread_contacts'        => ContactRequest::where('is_read', false)->count(),
            'unread_quotes'          => QuoteRequest::where('is_read', false)->count(),
            'projects_count'         => Project::count(),
            'blogs_count'            => BlogPost::count(),
            'gallery_count'          => GalleryItem::count(),
            'services_count'         => Service::count(),
            'testimonials_count'     => Testimonial::count(),
            'contact_requests_count' => ContactRequest::count(),
            'quote_requests_count'   => QuoteRequest::count(),
            'unread_contacts_count'  => ContactRequest::where('is_read', false)->count(),
            'unread_quotes_count'    => QuoteRequest::where('is_read', false)->count(),
            'newsletter_count'       => NewsletterSubscriber::where('is_active', true)->count(),
        ]);
    }

    public function getAdminStats()
    {
        return $this->getStats();
    }

    // --- GUIDEBOOK LEADS ---
    public function submitGuidebookLead(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
        ]);

        $lead = GuidebookLead::create($data);
        $activePdf = Setting::where('key', 'guidebook_pdf_url')->value('value') ?: asset('uploads/1785792673_new book.pdf');
        return response()->json([
            'success' => true,
            'message' => 'Guidebook lead recorded successfully',
            'lead'    => $lead,
            'pdf_url' => $activePdf
        ], 201);
    }

    public function getGuidebookLeads()
    {
        return response()->json(GuidebookLead::orderBy('id', 'desc')->get());
    }

    public function deleteGuidebookLead($id)
    {
        GuidebookLead::findOrFail($id)->delete();
        return response()->json(['message' => 'Lead deleted successfully']);
    }

    // --- GUIDEBOOK PDF SETTING ---
    public function updateGuidebookPdf(Request $request)
    {
        $request->validate(['url' => 'required|string']);
        $setting = Setting::updateOrCreate(['key' => 'guidebook_pdf_url'], ['value' => $request->url]);
        return response()->json([
            'success' => true,
            'message' => 'Guidebook PDF updated successfully',
            'setting' => $setting
        ]);
    }

    public function deleteGuidebookPdf()
    {
        Setting::where('key', 'guidebook_pdf_url')->delete();
        return response()->json([
            'success' => true,
            'message' => 'Guidebook PDF removed successfully'
        ]);
    }

    // --- INTRO VIDEO SETTING ---
    public function updateIntroVideo(Request $request)
    {
        $request->validate(['url' => 'required|string']);
        $setting = Setting::updateOrCreate(['key' => 'intro_video_url'], ['value' => $request->url]);
        return response()->json([
            'success' => true,
            'message' => 'Website Intro Video updated successfully',
            'setting' => $setting
        ]);
    }

    public function deleteIntroVideo()
    {
        Setting::where('key', 'intro_video_url')->delete();
        return response()->json([
            'success' => true,
            'message' => 'Website Intro Video removed successfully'
        ]);
    }

    // --- YOUTUBE VIDEO MANAGEMENT ---
    public function deleteYouTubeVideo($id)
    {
        $setting = Setting::where('key', 'youtube_synced_videos')->first();
        if ($setting && $setting->value) {
            $videos = json_decode($setting->value, true) ?: [];
            $filtered = array_values(array_filter($videos, function ($v) use ($id) {
                return ($v['id'] ?? $v['youtubeId'] ?? '') !== $id;
            }));
            $setting->update(['value' => json_encode($filtered)]);
            Setting::updateOrCreate(['key' => 'youtube_video_count'], ['value' => count($filtered)]);
            return response()->json([
                'success' => true,
                'message' => 'Video removed from synced list',
                'count'   => count($filtered)
            ]);
        }
        return response()->json(['success' => false, 'message' => 'No synced videos found'], 404);
    }
}


