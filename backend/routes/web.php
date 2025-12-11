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
use App\Http\Controllers\Web\UserAuthController;
use App\Http\Controllers\Web\UserReminderController;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

Route::get('/', [PageController::class, 'home']);
Route::get('/gallery', [PageController::class, 'gallery']);
Route::get('/priests', [PageController::class, 'priests']);
Route::get('/announcements', [PageController::class, 'announcements']);
Route::get('/schedule', [PageController::class, 'schedule']);
Route::get('/donate', [PageController::class, 'donate']);
Route::get('/user/donations', [PageController::class, 'userDonations']);
Route::get('/user/calendar', [PageController::class, 'userCalendar']);

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
        'name' => 'required|string|min:5|max:255',
        'email' => 'required|email',
        'message' => 'required|string|min:5',
    ]);
    ContactSubmission::create($validated);
    return redirect('/#contact')->with('status', 'Message sent successfully');
});

Route::post('/donate', function (Request $request) {
    if (!auth()->check()) {
        abort(302, '', ['Location' => '/login']);
    }
    $validated = $request->validate([
        'name' => 'required|string|min:5|max:100',
        'contact_number' => ['nullable','regex:/^9\d{9}$/'],
        'mode_of_payment' => 'nullable|string|min:5|max:100',
        'reference_number' => ['nullable','regex:/^\d{1,20}$/'],
        'donation_amount' => 'nullable|numeric',
    ]);
    $validated['user_id'] = auth()->id();
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

Route::prefix('admin')->middleware(\App\Http\Middleware\NoCache::class)->group(function () {
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
    Route::get('/announcements/archive', [AdminController::class, 'announcementsArchivePage']);
    Route::post('/announcements/{id}/archive', [AdminController::class, 'announcementsArchive']);
    Route::post('/announcements/{id}/unarchive', [AdminController::class, 'announcementsUnarchive']);

    Route::get('/priest', [AdminController::class, 'priestsIndex']);
    Route::post('/priest', [AdminController::class, 'priestsStore']);
    Route::post('/priest/{id}', [AdminController::class, 'priestsUpdate']);
    Route::post('/priest/{id}/delete', [AdminController::class, 'priestsDestroy']);
    Route::get('/priest/archive', [AdminController::class, 'priestsArchivePage']);
    Route::post('/priest/{id}/archive', [AdminController::class, 'priestsArchive']);
    Route::post('/priest/{id}/unarchive', [AdminController::class, 'priestsUnarchive']);

    Route::get('/gallery', [AdminController::class, 'galleryIndex']);
    Route::post('/gallery', [AdminController::class, 'galleryStore']);
    Route::post('/gallery/{id}', [AdminController::class, 'galleryUpdate']);
    Route::post('/gallery/{id}/delete', [AdminController::class, 'galleryDestroy']);
    Route::get('/gallery/archive', [AdminController::class, 'galleryArchivePage']);
    Route::post('/gallery/{id}/archive', [AdminController::class, 'galleryArchive']);
    Route::post('/gallery/{id}/unarchive', [AdminController::class, 'galleryUnarchive']);

    Route::get('/donations', [AdminController::class, 'donationsIndex']);
    Route::post('/donations/qr', [AdminController::class, 'donationsUpdateQR']);
    Route::get('/donations/archive', [AdminController::class, 'donationsArchivePage']);
    Route::post('/donations/{id}/archive', [AdminController::class, 'donationsArchive']);
    Route::post('/donations/{id}/unarchive', [AdminController::class, 'donationsUnarchive']);
    Route::get('/inquiries', [AdminController::class, 'inquiriesIndex']);
    Route::get('/inquiries/archive', [AdminController::class, 'inquiriesArchivePage']);
    Route::post('/inquiries/{id}/archive', [AdminController::class, 'inquiriesArchive']);
    Route::post('/inquiries/{id}/unarchive', [AdminController::class, 'inquiriesUnarchive']);
    Route::get('/search', [AdminController::class, 'search']);

    Route::get('/services', [AdminController::class, 'servicesIndex']);
    Route::post('/services', [AdminController::class, 'servicesStore']);
    Route::post('/services/{id}', [AdminController::class, 'servicesUpdate']);
    Route::post('/services/{id}/delete', [AdminController::class, 'servicesDestroy']);
    Route::get('/services/archive', [AdminController::class, 'servicesArchivePage']);
    Route::post('/services/{id}/archive', [AdminController::class, 'servicesArchive']);
    Route::post('/services/{id}/unarchive', [AdminController::class, 'servicesUnarchive']);

    Route::get('/schedule', [AdminController::class, 'scheduleIndex']);
    Route::post('/schedule', [AdminController::class, 'scheduleStore']);
    Route::post('/schedule/{id}', [AdminController::class, 'scheduleUpdate']);
    Route::post('/schedule/{id}/delete', [AdminController::class, 'scheduleDestroy']);
});

// User authentication and OTP flows
Route::get('/login', [UserAuthController::class, 'showLogin'])->name('login');
Route::post('/login', [UserAuthController::class, 'login']);
Route::post('/logout', [UserAuthController::class, 'logout'])->name('logout');
Route::get('/register', [UserAuthController::class, 'showRegister'])->name('register');
Route::post('/register/send-otp', [UserAuthController::class, 'sendRegisterOtp']);
Route::post('/register', [UserAuthController::class, 'register']);
Route::get('/forgot-password', [UserAuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [UserAuthController::class, 'sendResetOtp'])->name('password.email');
Route::get('/reset-password', [UserAuthController::class, 'showReset'])->name('password.reset');
Route::post('/reset-password', [UserAuthController::class, 'resetPassword'])->name('password.update');

Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');


// Legacy admin routes removed in favor of /admin group above
// User reminders
Route::post('/user/reminders', [UserReminderController::class, 'store']);
