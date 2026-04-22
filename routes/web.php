<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortalController::class, 'index'])->name('portal.index');
Route::get('/news/{news:slug}', [PortalController::class, 'show'])->name('portal.news.show');

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Apps Management
    Route::get('/apps', [AdminController::class, 'appsIndex'])->name('apps.index');
    Route::get('/apps/create', [AdminController::class, 'appsCreate'])->name('apps.create');
    Route::post('/apps', [AdminController::class, 'appsStore'])->name('apps.store');
    Route::get('/apps/{app}/edit', [AdminController::class, 'appsEdit'])->name('apps.edit');
    Route::put('/apps/{app}', [AdminController::class, 'appsUpdate'])->name('apps.update');
    Route::delete('/apps/{app}', [AdminController::class, 'appsDestroy'])->name('apps.destroy');

    // News Management
    Route::get('/news', [AdminController::class, 'newsIndex'])->name('news.index');
    Route::get('/news/create', [AdminController::class, 'newsCreate'])->name('news.create');
    Route::post('/news', [AdminController::class, 'newsStore'])->name('news.store');
    Route::get('/news/{news}/edit', [AdminController::class, 'newsEdit'])->name('news.edit');
    Route::put('/news/{news}', [AdminController::class, 'newsUpdate'])->name('news.update');
    Route::delete('/news/{news}', [AdminController::class, 'newsDestroy'])->name('news.destroy');

    // Site Profile Management
    Route::get('/profile-site', [AdminController::class, 'profileEdit'])->name('profile-site.edit');
    Route::put('/profile-site', [AdminController::class, 'profileUpdate'])->name('profile-site.update');

    // Organograms Management
    Route::resource('organograms', App\Http\Controllers\OrganogramController::class)->except(['show']);
});

// Redirect default dashboard to admin dashboard
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
