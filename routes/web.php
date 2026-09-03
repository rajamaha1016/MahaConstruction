<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes — Maha Construction
|--------------------------------------------------------------------------
*/

// ─── PUBLIC PAGES ───────────────────────────────────────────────────────────
Route::get('/',               [PageController::class, 'home'])->name('home');
Route::get('/services',       [PageController::class, 'services'])->name('services');
Route::get('/projects',       [PageController::class, 'projects'])->name('projects');
Route::get('/gallery',        [PageController::class, 'gallery'])->name('gallery');
Route::get('/testimonials',   [PageController::class, 'testimonials'])->name('testimonials');
Route::get('/calculator',     [PageController::class, 'calculator'])->name('calculator');
Route::redirect('/cost-calculator', '/calculator');
Route::get('/faq',            [PageController::class, 'faq'])->name('faq');
Route::get('/contact',        [PageController::class, 'contact'])->name('contact');
Route::get('/blog',           [PageController::class, 'blogIndex'])->name('blog');
Route::get('/blog/{slug}',    [PageController::class, 'blogShow'])->name('blog.show');
Route::get('/pricing',        [PageController::class, 'pricing'])->name('pricing');
Route::get('/about',          [PageController::class, 'about'])->name('about');
Route::get('/careers',        [PageController::class, 'careers'])->name('careers');
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms',          [PageController::class, 'terms'])->name('terms');
Route::get('/sitemap.xml',    [PageController::class, 'sitemap'])->name('sitemap');

// ─── ADMIN AUTHENTICATION ────────────────────────────────────────────────────
Route::get('/admin/login',    [AuthController::class, 'adminLoginPage'])->name('admin.login');
Route::post('/admin/login',   [AuthController::class, 'adminLoginPost'])->name('admin.login.post');
Route::post('/admin/logout',  [AuthController::class, 'adminLogout'])->name('admin.logout');

// ─── ADMIN DASHBOARD (protected) ────────────────────────────────────────────
Route::middleware('admin.auth')->group(function () {
    Route::get('/admin',           [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
});
