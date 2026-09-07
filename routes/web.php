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
Route::get('/projects',       [PageController::class, 'projects'])->name('projects');
Route::get('/testimonials',   [PageController::class, 'testimonials'])->name('testimonials');
Route::redirect('/calculator', '/pricing')->name('calculator');
Route::redirect('/cost-calculator', '/pricing');
Route::get('/pricing',        [PageController::class, 'pricing'])->name('pricing');

// ─── ADMIN AUTHENTICATION ────────────────────────────────────────────────────
Route::get('/admin/login',    [AuthController::class, 'adminLoginPage'])->name('admin.login');
Route::post('/admin/login',   [AuthController::class, 'adminLoginPost'])->name('admin.login.post');
Route::post('/admin/logout',  [AuthController::class, 'adminLogout'])->name('admin.logout');

// ─── ADMIN DASHBOARD (protected) ────────────────────────────────────────────
Route::middleware('admin.auth')->group(function () {
    Route::get('/admin',           [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
});
