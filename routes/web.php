<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GalleryAdminController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/learning', [PageController::class, 'learning'])->name('learning');
Route::get('/training', [PageController::class, 'training'])->name('training');
Route::get('/testimonials', [PageController::class, 'testimonials'])->name('testimonials');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

Route::get('/forms/{slug}', [PageController::class, 'form'])
    ->name('forms.show')
    ->where('slug', 'radio-ad|tailoring|printing|carpentry|contact');

Route::post('/forms/{formType}/submit', [InquiryController::class, 'store'])
    ->name('inquiries.store')
    ->where('formType', 'radio_ad|tailoring|printing|carpentry|contact');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::prefix('listings')->name('listings.')->group(function () {
    Route::get('/', [ListingController::class, 'index'])->name('index');

    Route::get('/post/lost', [ListingController::class, 'createLost'])->name('lost.create');
    Route::post('/post/lost', [ListingController::class, 'storeLost'])->name('lost.store');

    Route::get('/post/sale', [ListingController::class, 'createSale'])->name('sale.create');
    Route::post('/post/sale', [ListingController::class, 'storeSale'])->name('sale.store');

    Route::get('/post/rental', [ListingController::class, 'createRental'])->name('rental.create');
    Route::post('/post/rental', [ListingController::class, 'storeRental'])->name('rental.store');

    Route::get('/post/advert', [ListingController::class, 'createAdvert'])->name('advert.create');
    Route::post('/post/advert', [ListingController::class, 'storeAdvert'])->name('advert.store');

    Route::get('/post/found', [ListingController::class, 'createFound'])->name('found.create');
    Route::post('/post/found', [ListingController::class, 'storeFound'])->name('found.store');

    Route::get('/{listing}', [ListingController::class, 'show'])->name('show');
    Route::post('/{listing}/comments', [ListingController::class, 'storeComment'])
        ->middleware('throttle:30,1')
        ->name('comments.store');
});

Route::middleware(['auth', 'admin'])->prefix('listings')->name('listings.')->group(function () {
    Route::get('/admin/moderate', [ListingController::class, 'admin'])->name('admin');
    Route::get('/admin/comments', [ListingController::class, 'adminComments'])->name('admin.comments');
    Route::get('/admin/{listing}/edit', [ListingController::class, 'edit'])->name('edit');
    Route::put('/admin/{listing}', [ListingController::class, 'update'])->name('update');
    Route::delete('/admin/{listing}', [ListingController::class, 'destroy'])->name('destroy');
    Route::post('/admin/{listing}/approve', [ListingController::class, 'approve'])->name('approve');
    Route::post('/admin/{listing}/reject', [ListingController::class, 'reject'])->name('reject');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/gallery', [GalleryAdminController::class, 'index'])->name('gallery.index');
    Route::post('/gallery/categories', [GalleryAdminController::class, 'storeCategory'])->name('gallery.categories.store');
    Route::delete('/gallery/categories/{category}', [GalleryAdminController::class, 'destroyCategory'])->name('gallery.categories.destroy');
    Route::post('/gallery/photos', [GalleryAdminController::class, 'storePhoto'])->name('gallery.photos.store');
    Route::delete('/gallery/photos/{photo}', [GalleryAdminController::class, 'destroyPhoto'])->name('gallery.photos.destroy');
});
