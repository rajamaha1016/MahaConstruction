<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MediaUploadController;

/*
|--------------------------------------------------------------------------
| API Routes — Maha Construction REST API
|--------------------------------------------------------------------------
|
| Public endpoints: read-only content (GET) and lead-capture forms that
| anonymous site visitors submit (contact, quote, newsletter, guidebook,
| account auth). Everything that creates/edits/deletes managed content or
| exposes lead data is gated behind the same admin session used by the
| /admin dashboard, so the API can't be used to bypass that login.
|
*/

// ─── AUTH ────────────────────────────────────────────────────────────────────
Route::post('/auth/register',        [AuthController::class, 'register']);
Route::post('/auth/login',           [AuthController::class, 'login']);
Route::post('/auth/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/auth/reset-password',  [AuthController::class, 'resetPassword']);
Route::get('/auth/me',               [AuthController::class, 'me'])->middleware('auth:sanctum');

// ─── PUBLIC READS ────────────────────────────────────────────────────────────
Route::get('/testimonials',          [ApiController::class, 'getTestimonials']);
Route::get('/projects',              [ApiController::class, 'getProjects']);
Route::get('/projects/{id}',         [ApiController::class, 'getProject']);
Route::get('/services',              [ApiController::class, 'getServices']);
Route::get('/services/{slug}',       [ApiController::class, 'getService']);
Route::get('/gallery',               [ApiController::class, 'getGallery']);
Route::get('/blogs',                 [ApiController::class, 'getBlogs']);
Route::get('/blogs/{slug}',          [ApiController::class, 'getBlog']);
Route::get('/faqs',                  [ApiController::class, 'getFaqs']);
Route::get('/packages',              [ApiController::class, 'getPackages']);
Route::get('/partners',              [ApiController::class, 'getPartners']);
Route::get('/settings',              [ApiController::class, 'getSettings']);
Route::get('/settings/{key}',        [ApiController::class, 'getSetting']);
Route::get('/matrix/{division?}',    [ApiController::class, 'getPackageMatrix']);
Route::get('/stats',                 [ApiController::class, 'getStats']);
Route::get('/youtube/channel-videos',[ApiController::class, 'getYoutubeVideos']);

// ─── PUBLIC LEAD-CAPTURE FORMS (write, but anonymous by design) ─────────────
Route::post('/leads/contact',        [ApiController::class, 'submitContact']);
Route::post('/leads/quote',          [ApiController::class, 'submitQuote']);
Route::post('/leads/guidebook',      [ApiController::class, 'submitGuidebookLead']);
Route::post('/newsletter/subscribe', [ApiController::class, 'subscribeNewsletter']);

// ─── ADMIN-ONLY (content management, leads inbox, uploads, settings) ───────
// Uses admin.api.session to share session state without re-enforcing CSRF on API routes
Route::middleware(['admin.api.session', 'admin.auth'])->group(function () {
    // Testimonials
    Route::put('/testimonials/{id}',     [ApiController::class, 'updateTestimonial']);
    Route::post('/testimonials',         [ApiController::class, 'createTestimonial']);
    Route::delete('/testimonials/{id}',  [ApiController::class, 'deleteTestimonial']);

    // Projects
    Route::post('/projects',             [ApiController::class, 'createProject']);
    Route::put('/projects/{id}',         [ApiController::class, 'updateProject']);
    Route::delete('/projects/{id}',      [ApiController::class, 'deleteProject']);

    // Services
    Route::post('/services',             [ApiController::class, 'createService']);
    Route::put('/services/{id}',         [ApiController::class, 'updateService']);
    Route::delete('/services/{id}',      [ApiController::class, 'deleteService']);

    // Gallery
    Route::post('/gallery',              [ApiController::class, 'createGallery']);
    Route::put('/gallery/{id}',          [ApiController::class, 'updateGallery']);
    Route::delete('/gallery/{id}',       [ApiController::class, 'deleteGallery']);

    // Blogs
    Route::post('/blogs',                [ApiController::class, 'createBlog']);
    Route::put('/blogs/{id}',            [ApiController::class, 'updateBlog']);
    Route::delete('/blogs/{id}',         [ApiController::class, 'deleteBlog']);

    // FAQs
    Route::post('/faqs',                 [ApiController::class, 'createFaq']);
    Route::put('/faqs/{id}',             [ApiController::class, 'updateFaq']);
    Route::delete('/faqs/{id}',          [ApiController::class, 'deleteFaq']);

    // Packages
    Route::post('/packages',             [ApiController::class, 'createPackage']);
    Route::put('/packages/{id}',         [ApiController::class, 'updatePackage']);
    Route::delete('/packages/{id}',      [ApiController::class, 'deletePackage']);

    // Partners
    Route::post('/partners',             [ApiController::class, 'createPartner']);
    Route::put('/partners/{id}',         [ApiController::class, 'updatePartner']);
    Route::delete('/partners/{id}',      [ApiController::class, 'deletePartner']);

    // Settings
    Route::post('/settings',             [ApiController::class, 'saveSetting']);
    Route::post('/settings/matrix',      [ApiController::class, 'savePackageMatrix']);
    Route::get('/settings/matrix/{division?}', [ApiController::class, 'getPackageMatrix']);
    Route::post('/settings/contact',     [ApiController::class, 'saveContactSettings']);
    Route::post('/settings/guidebook',   [ApiController::class, 'updateGuidebookPdf']);
    Route::delete('/settings/guidebook', [ApiController::class, 'deleteGuidebookPdf']);
    Route::post('/settings/intro-video', [ApiController::class, 'updateIntroVideo']);
    Route::delete('/settings/intro-video',[ApiController::class, 'deleteIntroVideo']);

    // YouTube Sync & Settings
    Route::post('/youtube/sync',         [ApiController::class, 'syncYouTubeVideos']);
    Route::post('/youtube/settings',     [ApiController::class, 'saveYouTubeSettings']);
    Route::delete('/youtube/videos/{id}', [ApiController::class, 'deleteYouTubeVideo']);

    // Leads inbox (reading/managing submitted leads is admin-only)
    Route::get('/leads/contact',           [ApiController::class, 'getContacts']);
    Route::put('/leads/contact/{id}/read', [ApiController::class, 'markContactRead']);
    Route::delete('/leads/contact/{id}',   [ApiController::class, 'deleteContact']);

    Route::get('/leads/quote',              [ApiController::class, 'getQuotes']);
    Route::put('/leads/quote/{id}/read',    [ApiController::class, 'markQuoteRead']);
    Route::delete('/leads/quote/{id}',      [ApiController::class, 'deleteQuote']);

    Route::get('/leads/guidebook',          [ApiController::class, 'getGuidebookLeads']);
    Route::delete('/leads/guidebook/{id}',  [ApiController::class, 'deleteGuidebookLead']);

    Route::get('/newsletter/subscribers',   [ApiController::class, 'getNewsletterSubscribers']);

    // Media upload & management (Direct & Resilient Chunked Upload for files up to 2GB)
    Route::post('/upload',               [MediaUploadController::class, 'upload']);
    Route::post('/media/upload',         [MediaUploadController::class, 'upload']);
    Route::post('/upload/chunk',         [MediaUploadController::class, 'uploadChunk']);
    Route::post('/upload/finish',        [MediaUploadController::class, 'finishChunkedUpload']);
    Route::post('/upload/abort',         [MediaUploadController::class, 'abortChunkedUpload']);
    Route::get('/media',                 [MediaUploadController::class, 'listMedia']);
    Route::delete('/media/{id}',         [MediaUploadController::class, 'deleteMedia']);

    // Admin-only stats
    Route::get('/admin/stats',           [ApiController::class, 'getAdminStats']);

    // Admin credentials update
    Route::post('/admin/credentials',    [ApiController::class, 'updateAdminCredentials']);
});

