<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\ContactSubmission;
use App\Http\Controllers\Web\PageController;
use App\Http\Controllers\Api\AnnouncementController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\DonationController;
use App\Http\Controllers\Api\InquiryController;
use App\Http\Controllers\Api\PriestController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Web\AdminAuthController;
use App\Http\Controllers\Web\AdminController;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

Route::get('/', [PageController::class, 'home']);
Route::get('/gallery', [PageController::class, 'gallery']);
Route::get('/priests', [PageController::class, 'priests']);
Route::get('/announcements', [PageController::class, 'announcements']);
Route::get('/schedule', [PageController::class, 'schedule']);
Route::get('/donate', [PageController::class, 'donate']);
Route::get('/team', [PageController::class, 'team']);

// Square image resize endpoint using Intervention Image
Route::get('/image/square', function (Request $request) {
    $src = $request->query('src');
    $size = (int)($request->query('size', 400));
    if (!$src) {
        abort(400, 'Missing src');
    }
    $decoded = urldecode($src);
    $path = public_path(ltrim($decoded, '/'));
    if (!is_file($path)) {
        abort(404, 'Image not found');
    }
    $manager = new ImageManager(new Driver());
    $image = $manager->read($path)->cover($size, $size);
    $encoded = $image->toJpeg(90);
    return response((string)$encoded, 200, ['Content-Type' => 'image/jpeg']);
});

Route::get('/contact', function () {
    return view('contact');
});

Route::post('/contact', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'message' => 'required|string',
    ]);
    ContactSubmission::create($validated);
    return redirect('/#contact')->with('status', 'Message sent successfully');
});

Route::post('/donate', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'contact_number' => 'nullable|string|max:255',
        'mode_of_payment' => 'nullable|string|max:255',
        'reference_number' => 'nullable|string|max:255',
        'donation_amount' => 'nullable|numeric',
    ]);
    \App\Models\Donation::create($validated);
    return redirect('/donate')->with('status', 'Donation submitted');
});

Route::prefix('api')->group(function () {
    Route::apiResource('announcements', AnnouncementController::class);
    Route::apiResource('gallery', GalleryController::class);
    Route::apiResource('donations', DonationController::class);
    Route::apiResource('inquiries', InquiryController::class);
    Route::apiResource('priests', PriestController::class);
    Route::apiResource('schedules', ScheduleController::class);
});

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin']);
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout']);
    Route::get('/register', [AdminAuthController::class, 'showRegister']);
    Route::post('/register', [AdminAuthController::class, 'register']);
    Route::get('/forgot-password', [AdminAuthController::class, 'showForgotPassword']);
    Route::post('/forgot-password', [AdminAuthController::class, 'forgotPassword']);

    Route::get('/', [AdminController::class, 'dashboard']);
    Route::get('/announcements', [AdminController::class, 'announcementsIndex']);
    Route::post('/announcements', [AdminController::class, 'announcementsStore']);
    Route::post('/announcements/{id}', [AdminController::class, 'announcementsUpdate']);
    Route::post('/announcements/{id}/delete', [AdminController::class, 'announcementsDestroy']);

    Route::get('/priest', [AdminController::class, 'priestsIndex']);
    Route::post('/priest', [AdminController::class, 'priestsStore']);
    Route::post('/priest/{id}', [AdminController::class, 'priestsUpdate']);
    Route::post('/priest/{id}/delete', [AdminController::class, 'priestsDestroy']);

    Route::get('/gallery', [AdminController::class, 'galleryIndex']);
    Route::post('/gallery', [AdminController::class, 'galleryStore']);
    Route::post('/gallery/{id}', [AdminController::class, 'galleryUpdate']);
    Route::post('/gallery/{id}/delete', [AdminController::class, 'galleryDestroy']);

    Route::get('/donations', [AdminController::class, 'donationsIndex']);
    Route::post('/donations/qr', [AdminController::class, 'donationsUpdateQR']);
    Route::get('/inquiries', [AdminController::class, 'inquiriesIndex']);
});


// Legacy admin routes removed in favor of /admin group above
