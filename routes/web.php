<?php

use App\Http\Controllers\InquiryController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/learning', [PageController::class, 'learning'])->name('learning');
Route::get('/training', [PageController::class, 'training'])->name('training');
Route::get('/gallery', [PageController::class, 'gallery'])->name('gallery');
Route::get('/testimonials', [PageController::class, 'testimonials'])->name('testimonials');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

Route::get('/forms/{slug}', [PageController::class, 'form'])
    ->name('forms.show')
    ->where('slug', 'radio-ad|tailoring|printing|carpentry|contact');

Route::post('/forms/{formType}/submit', [InquiryController::class, 'store'])
    ->name('inquiries.store')
    ->where('formType', 'radio_ad|tailoring|printing|carpentry|contact');
