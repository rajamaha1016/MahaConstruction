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
use App\Services\PackageMatrixService;
use App\Services\AnalyticsService;

class ApiController extends Controller
{
    // --- TESTIMONIALS ---
    public function getTestimonials(Request $request)
    {
        $query = Testimonial::orderBy('id', 'desc');
        if ($request->filled('business_type')) {
            $query->where('business_type', $request->query('business_type'));
        }
        return response()->json($query->get());
    }

    public function createTestimonial(Request $request)
    {
        $data = $request->validate([
            'client_name'   => 'required|string',
            'client_role'   => 'nullable|string',
            'rating'        => 'nullable|integer',
            'feedback'      => 'nullable|string',
            'image_url'     => 'nullable|string',
            'video_url'     => 'nullable|string',
            'project_name'  => 'nullable|string',
            'duration'      => 'nullable|string',
            'business_type' => 'nullable|string|in:construction,interior',
        ]);
        if (empty($data['business_type'])) {
            $data['business_type'] = 'construction';
        }
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
    public function getProjects(Request $request)
    {
        $query = Project::orderBy('id', 'desc');
        if ($request->filled('business_type')) {
            $query->where('business_type', $request->query('business_type'));
        }
        return response()->json($query->get());
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
            'business_type'      => 'nullable|string|in:construction,interior',
        ]);
        if (empty($data['business_type'])) {
            $data['business_type'] = 'construction';
        }
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
    public function getServices(Request $request)
    {
        $query = Service::query();
        if ($request->filled('business_type')) {
            $query->where('business_type', $request->query('business_type'));
        }
        return response()->json($query->get());
    }

    public function getService($slug)
    {
        return response()->json(Service::where('slug', $slug)->firstOrFail());
    }

    public function createService(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|string|unique:services,name',
            'slug'          => 'required|string|unique:services,slug',
            'overview'      => 'nullable|string',
            'benefits'      => 'nullable|array',
            'process'       => 'nullable|array',
            'image_url'     => 'nullable|string',
            'category'      => 'nullable|string',
            'business_type' => 'nullable|string|in:construction,interior',
        ]);
        if (empty($data['business_type'])) {
            $data['business_type'] = 'construction';
        }
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
    public function getGallery(Request $request)
    {
        $query = GalleryItem::orderBy('id', 'desc');
        if ($request->filled('business_type')) {
            $query->where('business_type', $request->query('business_type'));
        }
        return response()->json($query->get());
    }

    public function createGallery(Request $request)
    {
        $data = $request->validate([
            'title'           => 'required|string',
            'category'        => 'required|string',
            'image_url'       => 'required|string',
            'is_video'        => 'nullable|boolean',
            'video_url'       => 'nullable|string',
            'three_sixty_url' => 'nullable|string',
            'business_type'   => 'nullable|string|in:construction,interior',
        ]);
        if (empty($data['business_type'])) {
            $data['business_type'] = 'construction';
        }
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
    public function getPackages(Request $request)
    {
        $query = PackageDetail::query();
        if ($request->filled('business_type')) {
            $query->where('business_type', $request->query('business_type'));
        }
        return response()->json($query->get());
    }

    public function createPackage(Request $request)
    {
        $data = $request->all();
        if (empty($data['business_type'])) {
            $data['business_type'] = 'construction';
        }
        return response()->json(PackageDetail::create($data), 201);
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

    // --- PACKAGE COMPARISON MATRIX ---
    public function getPackageMatrix($division = 'residential')
    {
        $matrix = PackageMatrixService::getMatrix($division);
        return response()->json([
            'success'  => true,
            'division' => strtolower($division),
            'matrix'   => $matrix
        ]);
    }

    public function savePackageMatrix(Request $request)
    {
        $request->validate([
            'division' => 'required|string',
            'matrix'   => 'required',
        ]);

        $division = strtolower($request->division);
        $matrixData = is_string($request->matrix) ? json_decode($request->matrix, true) : $request->matrix;

        if (!is_array($matrixData)) {
            return response()->json(['success' => false, 'message' => 'Invalid matrix format'], 422);
        }

        $saved = PackageMatrixService::saveMatrix($division, $matrixData);

        return response()->json([
            'success' => true,
            'message' => ucfirst($division) . ' comparison matrix saved successfully!',
            'matrix'  => $saved
        ]);
    }

    public function saveContactSettings(Request $request)
    {
        $fields = [
            'company_phone',
            'company_phone_secondary',
            'company_whatsapp',
            'company_email',
            'company_address',
            'company_hours',
            'company_branches',
            'company_map_embed',
            // Hero section content
            'hero_title',
            'hero_subtitle',
            'hero_check1',
            'hero_check2',
            'hero_check3',
            'hero_check4',
            'hero_check5',
            'hero_cta_primary',
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                Setting::updateOrCreate(
                    ['key' => $field],
                    ['value' => $request->input($field, '')]
                );
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Contact details & address saved successfully!',
            'settings' => Setting::all()->keyBy('key')
        ]);
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
        // SERVER-ENFORCED: Construction contact submissions are always construction
        $data['business_type'] = 'construction';
        $contact = ContactRequest::create($data);

        // Record successful contact submission in analytics (only after DB success)
        try {
            app(AnalyticsService::class)->recordEvent([
                'business_type' => 'construction',
                'event_type'    => 'contact_submitted',
                'visitor_id'    => $request->input('visitor_id'),
                'session_id'    => $request->input('session_id'),
                'lead_id'       => $contact->id,
                'lead_type'     => 'contact_request',
                'page_name'     => 'contact',
                'utm_source'    => $request->input('utm_source'),
                'utm_medium'    => $request->input('utm_medium'),
                'utm_campaign'  => $request->input('utm_campaign'),
                'referrer'      => $request->input('referrer'),
            ], $request);

            app(AnalyticsService::class)->recordEvent([
                'business_type' => 'construction',
                'event_type'    => 'enquiry_submitted',
                'visitor_id'    => $request->input('visitor_id'),
                'session_id'    => $request->input('session_id'),
                'lead_id'       => $contact->id,
                'lead_type'     => 'contact_request',
                'page_name'     => 'contact',
                'utm_source'    => $request->input('utm_source'),
                'utm_medium'    => $request->input('utm_medium'),
                'utm_campaign'  => $request->input('utm_campaign'),
                'referrer'      => $request->input('referrer'),
            ], $request);
        } catch (\Throwable $e) {
            // Analytics logging failure must never block customer lead submission
        }

        return response()->json(['message' => 'Contact lead submitted successfully', 'lead' => $contact], 201);
    }

    public function getContacts(Request $request)
    {
        $query = ContactRequest::orderBy('id', 'desc');
        if ($request->filled('business_type')) {
            $query->where('business_type', $request->query('business_type'));
        }
        return response()->json($query->get());
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
        // SERVER-ENFORCED: Construction proposal requests are always construction
        $data['business_type'] = 'construction';
        $quote = QuoteRequest::create($data);

        // Record successful quote submission in analytics (only after DB success)
        try {
            app(AnalyticsService::class)->recordEvent([
                'business_type' => 'construction',
                'event_type'    => 'quote_submitted',
                'visitor_id'    => $request->input('visitor_id'),
                'session_id'    => $request->input('session_id'),
                'lead_id'       => $quote->id,
                'lead_type'     => 'quote_request',
                'page_name'     => 'pricing',
                'utm_source'    => $request->input('utm_source'),
                'utm_medium'    => $request->input('utm_medium'),
                'utm_campaign'  => $request->input('utm_campaign'),
                'referrer'      => $request->input('referrer'),
            ], $request);

            app(AnalyticsService::class)->recordEvent([
                'business_type' => 'construction',
                'event_type'    => 'enquiry_submitted',
                'visitor_id'    => $request->input('visitor_id'),
                'session_id'    => $request->input('session_id'),
                'lead_id'       => $quote->id,
                'lead_type'     => 'quote_request',
                'page_name'     => 'pricing',
                'utm_source'    => $request->input('utm_source'),
                'utm_medium'    => $request->input('utm_medium'),
                'utm_campaign'  => $request->input('utm_campaign'),
                'referrer'      => $request->input('referrer'),
            ], $request);
        } catch (\Throwable $e) {
            // Analytics logging failure must never block customer lead submission
        }

        return response()->json(['message' => 'Quote request submitted', 'lead' => $quote], 201);
    }

    public function submitInteriorEnquiry(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string',
            'email'        => 'required|email',
            'phone'        => 'nullable|string',
            'project_type' => 'nullable|string',
            'budget_range' => 'nullable|string',
            'message'      => 'nullable|string',
        ]);
        // SERVER-ENFORCED: Interior enquiries are always interior, client input cannot override
        $data['business_type'] = 'interior';
        if (empty($data['project_type'])) {
            $data['project_type'] = 'Interior Design & Execution';
        }
        $quote = QuoteRequest::create($data);

        // Record successful interior consultation / enquiry in analytics (only after DB success)
        try {
            app(AnalyticsService::class)->recordEvent([
                'business_type' => 'interior',
                'event_type'    => 'enquiry_submitted',
                'visitor_id'    => $request->input('visitor_id'),
                'session_id'    => $request->input('session_id'),
                'lead_id'       => $quote->id,
                'lead_type'     => 'quote_request',
                'page_name'     => 'interior',
                'section_name'  => 'enquiry',
                'utm_source'    => $request->input('utm_source'),
                'utm_medium'    => $request->input('utm_medium'),
                'utm_campaign'  => $request->input('utm_campaign'),
                'referrer'      => $request->input('referrer'),
            ], $request);
        } catch (\Throwable $e) {
            // Analytics logging failure must never block customer lead submission
        }

        return response()->json(['message' => 'Interior enquiry submitted successfully', 'lead' => $quote], 201);
    }


    public function getQuotes(Request $request)
    {
        $query = QuoteRequest::orderBy('id', 'desc');
        if ($request->filled('business_type')) {
            $query->where('business_type', $request->query('business_type'));
        }
        return response()->json($query->get());
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
        $videos = [];
        if ($setting && !empty($setting->value)) {
            $videos = json_decode($setting->value, true) ?: [];
        }

        if (empty($videos)) {
            try {
                $ytService = app(YouTubeSyncService::class);
                $targetUrl = YouTubeSyncService::getActiveChannelUrl();
                $videos = $ytService->getVideos($targetUrl)['videos'] ?? [];
            } catch (\Throwable $e) {}
        }

        // Add to persistent hidden video blacklist
        $hiddenIds = YouTubeSyncService::getHiddenVideoIds();
        if (!in_array($id, $hiddenIds)) {
            $hiddenIds[] = $id;
            Setting::updateOrCreate(
                ['key' => 'youtube_hidden_video_ids'],
                ['value' => json_encode(array_values($hiddenIds))]
            );
        }

        $filtered = array_values(array_filter($videos, function ($v) use ($id, $hiddenIds) {
            $vidId = $v['id'] ?? $v['youtubeId'] ?? '';
            return $vidId !== $id && !in_array($vidId, $hiddenIds);
        }));

        Setting::updateOrCreate(['key' => 'youtube_synced_videos'], ['value' => json_encode($filtered)]);
        Setting::updateOrCreate(['key' => 'youtube_video_count'], ['value' => (string)count($filtered)]);

        // Invalidate cache so both construction and interior pages update in real-time
        try {
            $activeUrl = YouTubeSyncService::getActiveChannelUrl();
            \Illuminate\Support\Facades\Cache::forget('yt_live_videos_' . md5($activeUrl));
            \Illuminate\Support\Facades\Cache::flush();
        } catch (\Throwable $e) {}

        return response()->json([
            'success'    => true,
            'message'    => 'Video successfully removed from website showcase',
            'count'      => count($filtered),
            'deleted_id' => $id
        ]);
    }

    public function restoreYouTubeVideo($id)
    {
        $hiddenIds = YouTubeSyncService::getHiddenVideoIds();
        $hiddenIds = array_values(array_filter($hiddenIds, fn($v) => $v !== $id));
        Setting::updateOrCreate(
            ['key' => 'youtube_hidden_video_ids'],
            ['value' => json_encode($hiddenIds)]
        );

        try {
            $activeUrl = YouTubeSyncService::getActiveChannelUrl();
            \Illuminate\Support\Facades\Cache::forget('yt_live_videos_' . md5($activeUrl));
            \Illuminate\Support\Facades\Cache::flush();
        } catch (\Throwable $e) {}

        return response()->json([
            'success' => true,
            'message' => 'Video restored to website showcase'
        ]);
    }

    // --- ADMIN CREDENTIALS ---
    public function updateAdminCredentials(Request $request)
    {
        $currentEmail = session('admin_email');
        $user = ($currentEmail ? \App\Models\User::where('email', $currentEmail)->first() : null)
            ?? \App\Models\User::where('role', 'admin')->first()
            ?? \App\Models\User::first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Admin account not found in database.'], 404);
        }

        $request->validate([
            'email'        => 'required|email|unique:users,email,' . $user->id,
            'password'     => 'nullable|string|min:6',
            'new_password' => 'nullable|string|min:6',
        ], [
            'email.required' => 'An admin email address is required.',
            'email.email'    => 'Please provide a valid email address.',
            'email.unique'   => 'This email address is already associated with another account.',
            'password.min'   => 'New password must be at least 6 characters long.',
            'new_password.min' => 'New password must be at least 6 characters long.',
        ]);

        $user->email = strtolower(trim($request->email));

        $pwd = $request->input('password') ?: $request->input('new_password');
        if (!empty($pwd)) {
            $user->password = \Illuminate\Support\Facades\Hash::make($pwd);
        }

        $user->save();

        // Refresh admin session with the new credentials
        session([
            'admin_authenticated' => true,
            'admin_email'         => $user->email,
            'admin_name'          => $user->full_name ?? 'Maha Admin',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Credentials updated successfully! You can now log in with your updated email and password.',
            'email'   => $user->email,
        ]);
    }

    // --- WEBSITE & LEAD ANALYTICS ---
    public function recordAnalyticsEvent(Request $request, AnalyticsService $service)
    {
        $validated = $request->validate([
            'business_type' => 'required|string|in:construction,interior',
            'event_type'    => 'required|string|in:page_view,session_start,section_view,project_view,package_view,consultation_click,enquiry_submitted,quote_submitted,contact_submitted',
            'visitor_id'    => 'nullable|string|max:64',
            'session_id'    => 'nullable|string|max:64',
            'page_url'      => 'nullable|string|max:2048',
            'page_name'     => 'nullable|string|max:100',
            'section_name'  => 'nullable|string|max:100',
            'item_id'       => 'nullable|string|max:100',
            'referrer'      => 'nullable|string|max:2048',
            'utm_source'    => 'nullable|string|max:100',
            'utm_medium'    => 'nullable|string|max:100',
            'utm_campaign'  => 'nullable|string|max:100',
            'device_type'   => 'nullable|string|in:mobile,desktop,tablet,unknown',
        ]);

        $event = $service->recordEvent($validated, $request);

        return response()->json([
            'success' => (bool)$event,
            'event'   => $event ? [
                'id'            => $event->id,
                'business_type' => $event->business_type,
                'event_type'    => $event->event_type,
            ] : null,
        ], $event ? 201 : 422);
    }

    public function getAdminAnalytics(Request $request, AnalyticsService $service)
    {
        $division = strtolower(trim($request->query('division', 'all')));
        if (!in_array($division, ['all', 'construction', 'interior'], true)) {
            $division = 'all';
        }

        $period = strtolower(trim($request->query('period', '30days')));
        if (!in_array($period, ['today', '7days', '30days', '3months', '1year'], true)) {
            $period = '30days';
        }

        $data = $service->getOverview($division, $period);
        return response()->json($data);
    }
}




