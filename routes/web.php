<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Propietario\BusinessController;
use App\Http\Controllers\Propietario\BusinessItemController;
use App\Http\Controllers\Public\BusinessController as PublicBusinessController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\BusinessController as AdminBusinessController;
use App\Http\Controllers\Admin\BusinessTypeController as AdminBusinessTypeController;

use App\Http\Controllers\Propietario\DashboardController as PropietarioDashboard;

Route::get('/', function () {
    return view('welcome');
});

// Rutas públicas - Ver negocios y items
Route::prefix('negocios')->name('negocios.')->group(function () {
    Route::get('/', [PublicBusinessController::class, 'index'])->name('index');
    Route::get('/categoria/{type}', [PublicBusinessController::class, 'category'])->name('category');
    Route::get('/{slug}', [PublicBusinessController::class, 'show'])->name('show');
});

// Admin
Route::middleware(['auth','admin'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboard::class, 'index'])
            ->name('admin.dashboard');
            
        Route::get('/businesses', [AdminBusinessController::class, 'index'])
            ->name('business.index');

        Route::patch('/businesses/{business}/toggle', [AdminBusinessController::class, 'toggle'])
            ->name('business.toggle');
        
        // Manage business types
        Route::resource('business-types', AdminBusinessTypeController::class)->except(['show']);
            
    });

//propietario   
Route::middleware(['auth', 'propietario'])
    ->prefix('propietario')
    ->name('propietario.')
    ->group(function () {
        Route::get('/dashboard', [PropietarioDashboard::class, 'index'])
            ->name('dashboard');
        Route::resource('negocios', BusinessController::class);
        Route::get('/businesses', [Propietario\BusinessController::class, 'index'])
            ->name('business.index');

        Route::get('/businesses/create', [Propietario\BusinessController::class, 'create'])
            ->name('business.create');
        Route::delete('negocios/{negocio}/remove-image', [BusinessController::class, 'removeImage'])
            ->name('negocios.remove-image');
        Route::patch('negocios/{negocio}/set-featured-image', [BusinessController::class, 'setFeaturedImage'])
            ->name('negocios.set-featured-image');
        Route::post('/businesses', [Propietario\BusinessController::class, 'store'])
            ->name('business.store');
  Route::resource('negocios.items', BusinessItemController::class);
    Route::delete('negocios/items/{item}/remove-image', [BusinessItemController::class, 'removeImage'])
         ->name('negocios.items.remove-image');
    Route::patch('negocios/{negocio}/items/{item}/set-featured-image', [BusinessItemController::class, 'setFeaturedImage'])
         ->name('negocios.items.set-featured-image');

});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
