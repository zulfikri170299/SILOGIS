<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DocumentFolderController;
use App\Http\Controllers\Admin\BagAdaInputController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PortalController::class, 'index'])->name('portal.index');
Route::get('/folders/{documentFolder}/download', [PortalController::class, 'downloadFolder'])->name('portal.folders.download');
Route::get('/news', [PortalController::class, 'newsIndex'])->name('portal.news.index');
Route::get('/news/{news:slug}', [PortalController::class, 'show'])->name('portal.news.show');
Route::post('/visitor/register', [\App\Http\Controllers\VisitorController::class, 'register'])->name('visitor.register');

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Superadmin Only Routes
    Route::middleware('role:superadmin')->group(function () {
        // Apps Management
        Route::get('/apps', [AdminController::class, 'appsIndex'])->name('apps.index');
        Route::get('/apps/create', [AdminController::class, 'appsCreate'])->name('apps.create');
        Route::post('/apps', [AdminController::class, 'appsStore'])->name('apps.store');
        Route::get('/apps/{app}/edit', [AdminController::class, 'appsEdit'])->name('apps.edit');
        Route::put('/apps/{app}', [AdminController::class, 'appsUpdate'])->name('apps.update');
        Route::delete('/apps/{app}', [AdminController::class, 'appsDestroy'])->name('apps.destroy');
        
        // Future Superadmin routes (Users, Bagian, Satker) will go here
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::resource('bagians', \App\Http\Controllers\Admin\BagianController::class);
        Route::resource('satkers', \App\Http\Controllers\Admin\SatkerController::class);
        Route::get('/visitors/print', [\App\Http\Controllers\Admin\VisitorAdminController::class, 'print'])->name('visitors.print');
        Route::get('/visitors', [\App\Http\Controllers\Admin\VisitorAdminController::class, 'index'])->name('visitors.index');
    });

    // Satker Inputs Routes
    Route::get('/bagian/{bagian}/inputs', [\App\Http\Controllers\Admin\SatkerInputController::class, 'index'])->name('satker_inputs.index');
    Route::get('/bagian/{bagian}/inputs/create', [\App\Http\Controllers\Admin\SatkerInputController::class, 'create'])->name('satker_inputs.create');
    Route::post('/bagian/{bagian}/inputs', [\App\Http\Controllers\Admin\SatkerInputController::class, 'store'])->name('satker_inputs.store');
    Route::delete('/satker-inputs/{id}', [\App\Http\Controllers\Admin\SatkerInputController::class, 'destroy'])->name('satker_inputs.destroy');

    // Superadmin and Admin Satker Routes
    Route::middleware('role:superadmin,admin_satker')->group(function () {
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

        // Logo Management
        Route::get('/logo', [AdminController::class, 'logoEdit'])->name('logo.edit');
        Route::put('/logo', [AdminController::class, 'logoUpdate'])->name('logo.update');

        // Organograms Management
        Route::resource('organograms', App\Http\Controllers\OrganogramController::class)->except(['show']);

        // Documents Management
        Route::resource('documents', DocumentController::class);
        Route::resource('document-folders', DocumentFolderController::class);
    });

    // Master Bag Ada routes (for Superadmin or Admin Bag Ada)
    Route::middleware('role:superadmin,admin_bag')->group(function () {
        Route::resource('master-pelaku', \App\Http\Controllers\Admin\MasterPelakuPengadaanController::class);
        Route::resource('master-metode', \App\Http\Controllers\Admin\MasterMetodePengadaanController::class);
    });

    // Bag Ada Inputs (for Superadmin, Admin Bag Ada, Admin Satker)
    // We already have 'role:superadmin,admin_satker' earlier, but Admin Bag can view all. 
    // Let's just group them without middleware (it's inside 'auth' and 'admin' prefix).
    Route::get('/bag-ada-inputs/export', [BagAdaInputController::class, 'export'])->name('bag-ada-inputs.export');
    Route::get('/bag-ada-inputs/template', [BagAdaInputController::class, 'downloadTemplate'])->name('bag-ada-inputs.template');
    Route::post('/bag-ada-inputs/import', [BagAdaInputController::class, 'import'])->name('bag-ada-inputs.import');
    Route::post('/bag-ada-inputs/import-validate', [BagAdaInputController::class, 'importValidate'])->name('bag-ada-inputs.import-validate');
    Route::post('/bag-ada-inputs/import-process', [BagAdaInputController::class, 'importProcess'])->name('bag-ada-inputs.import-process');
    Route::delete('/bag-ada-inputs/bulk-destroy', [BagAdaInputController::class, 'bulkDestroy'])->name('bag-ada-inputs.bulk-destroy');
    Route::resource('bag-ada-inputs', BagAdaInputController::class)->except(['create', 'show']);

    // All Admins (including Admin Bag) Routes
    // BWS Management
    Route::get('/bws', [\App\Http\Controllers\Admin\BwsAdminController::class, 'index'])->name('bws.index');
    Route::get('/bws/print', [\App\Http\Controllers\Admin\BwsAdminController::class, 'printReport'])->name('bws.print');
    Route::put('/bws/logo', [\App\Http\Controllers\Admin\BwsAdminController::class, 'updateLogo'])->name('bws.logo.update');
    Route::delete('/bws/{bws}', [\App\Http\Controllers\Admin\BwsAdminController::class, 'destroy'])->name('bws.destroy');
});

// BWS Portal
Route::get('/bws', [\App\Http\Controllers\Portal\BwsController::class, 'index'])->name('portal.bws.index');
Route::post('/bws', [\App\Http\Controllers\Portal\BwsController::class, 'store'])->name('portal.bws.store');

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
