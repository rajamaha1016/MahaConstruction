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
    public function dashboard()
    {
        $stats = [
            'projects'                  => Project::count(),
            'projects_construction'     => Project::where('business_type', 'construction')->count(),
            'projects_interior'         => Project::where('business_type', 'interior')->count(),
            'services'                  => Service::count(),
            'services_construction'     => Service::where('business_type', 'construction')->count(),
            'services_interior'         => Service::where('business_type', 'interior')->count(),
            'testimonials'              => Testimonial::count(),
            'testimonials_construction' => Testimonial::where('business_type', 'construction')->count(),
            'testimonials_interior'     => Testimonial::where('business_type', 'interior')->count(),
            'packages'                  => PackageDetail::count(),
            'packages_construction'     => PackageDetail::where('business_type', 'construction')->count(),
            'packages_interior'         => PackageDetail::where('business_type', 'interior')->count(),
            'contacts'                  => ContactRequest::count(),
            'quotes'                    => QuoteRequest::count(),
            'quotes_construction'       => QuoteRequest::where('business_type', 'construction')->count(),
            'quotes_interior'           => QuoteRequest::where('business_type', 'interior')->count(),
            'blogs'                     => BlogPost::count(),
            'gallery'                   => GalleryItem::count(),
            'partners'                  => Partner::count(),
            'newsletter'                => NewsletterSubscriber::where('is_active', true)->count(),
            'unread_contacts'           => ContactRequest::where('is_read', false)->count(),
            'unread_quotes'             => QuoteRequest::where('is_read', false)->count(),
        ];

        $projects     = Project::orderBy('id', 'desc')->get();
        $services     = Service::all();
        $gallery      = GalleryItem::orderBy('id', 'desc')->get();
        $blogs        = BlogPost::orderBy('id', 'desc')->get();
        $testimonials = Testimonial::orderBy('id', 'desc')->get();
        $faqs         = FAQItem::all();
        $contacts     = ContactRequest::orderBy('id', 'desc')->get();
        $quotes       = QuoteRequest::orderBy('id', 'desc')->get();
        $packages     = PackageDetail::all();
        $partners     = Partner::all();
        $newsletter   = NewsletterSubscriber::orderBy('id', 'desc')->get();
        $settings     = Setting::all()->keyBy('key');

        $adminUser    = User::where('email', session('admin_email'))->first()
            ?? User::where('role', 'admin')->first()
            ?? User::first();

        return view('admin.dashboard', compact(
            'stats', 'projects', 'services', 'gallery', 'blogs',
            'testimonials', 'faqs', 'contacts', 'quotes',
            'packages', 'partners', 'newsletter', 'settings', 'adminUser'
        ));
    }
}

