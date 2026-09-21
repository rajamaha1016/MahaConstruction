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
use App\Models\PackageDetail;
use App\Models\Partner;
use App\Models\NewsletterSubscriber;
use App\Models\Setting;
use App\Models\User;

class AdminController extends Controller
{
    public function redirectDashboard(Request $request)
    {
        $preferredDivision = session('maha_admin_division', 'construction');
        if ($preferredDivision === 'interior') {
            return redirect()->route('admin.interior');
        }
        return redirect()->route('admin.construction');
    }

    public function dashboard(Request $request)
    {
        return $this->redirectDashboard($request);
    }

    public function constructionDashboard(Request $request)
    {
        session(['maha_admin_division' => 'construction']);
        return $this->renderDivisionDashboard('construction');
    }

    public function interiorDashboard(Request $request)
    {
        session(['maha_admin_division' => 'interior']);
        return $this->renderDivisionDashboard('interior');
    }

    protected function renderDivisionDashboard(string $division)
    {
        $activeDivision = $division;

        // Division-specific content — strictly isolated
        $projects     = Project::where('business_type', $division)->orderBy('id', 'desc')->get();
        $services     = Service::where('business_type', $division)->orderBy('id', 'desc')->get();
        $gallery      = GalleryItem::where('business_type', $division)->orderBy('id', 'desc')->get();
        $testimonials = Testimonial::where('business_type', $division)->orderBy('id', 'desc')->get();
        $packages     = PackageDetail::where('business_type', $division)->orderBy('id', 'desc')->get();
        $quotes       = QuoteRequest::where('business_type', $division)->orderBy('id', 'desc')->get();

        // Common / Shared content accessible on both pages
        $partners     = Partner::all();
        $contacts     = ContactRequest::orderBy('id', 'desc')->get();
        $newsletter   = NewsletterSubscriber::orderBy('id', 'desc')->get();
        $settings     = Setting::all()->keyBy('key');
        $blogs        = BlogPost::orderBy('id', 'desc')->get();
        $faqs         = FAQItem::all();

        $stats = [
            'division'        => $division,
            'projects'        => $projects->count(),
            'services'        => $services->count(),
            'testimonials'    => $testimonials->count(),
            'reviews'         => $testimonials->count(),
            'packages'        => $packages->count(),
            'quotes'          => $quotes->count(),
            'unread_quotes'   => $quotes->where('is_read', false)->count(),
            'gallery'         => $gallery->count(),
            // Shared stats
            'contacts'        => $contacts->count(),
            'unread_contacts' => $contacts->where('is_read', false)->count(),
            'partners'        => $partners->count(),
            'newsletter'      => $newsletter->where('is_active', true)->count(),
            'blogs'           => $blogs->count(),
        ];

        $adminUser = User::where('email', session('admin_email'))->first()
            ?? User::where('role', 'admin')->first()
            ?? User::first();

        return view('admin.dashboard', compact(
            'activeDivision', 'stats', 'projects', 'services', 'gallery', 'blogs',
            'testimonials', 'faqs', 'contacts', 'quotes',
            'packages', 'partners', 'newsletter', 'settings', 'adminUser'
        ));
    }
}


