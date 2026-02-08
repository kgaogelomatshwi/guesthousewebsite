<?php

use App\Http\Controllers\Admin\AmenityController as AdminAmenityController;
use App\Http\Controllers\Admin\AttractionController as AdminAttractionController;
use App\Http\Controllers\Admin\BlogCategoryController as AdminBlogCategoryController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\BookingBlockController as AdminBookingBlockController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EnquiryController as AdminEnquiryController;
use App\Http\Controllers\Admin\ExternalBookingController as AdminExternalBookingController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\MediaController as AdminMediaController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\PageSectionController as AdminPageSectionController;
use App\Http\Controllers\Admin\RateController as AdminRateController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Public\AnalyticsController;
use App\Http\Controllers\Public\AttractionController;
use App\Http\Controllers\Public\BlogController;
use App\Http\Controllers\Public\BookingController;
use App\Http\Controllers\Public\EnquiryController;
use App\Http\Controllers\Public\ExternalBookingController;
use App\Http\Controllers\Public\GalleryController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\PageController;
use App\Http\Controllers\Public\RoomController;
use App\Http\Controllers\Public\SearchController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', [PageController::class, 'show'])->defaults('key', 'about')->name('pages.about');
Route::get('/services', [PageController::class, 'show'])->defaults('key', 'services')->name('pages.services');
Route::get('/rates', [PageController::class, 'show'])->defaults('key', 'rates')->name('pages.rates');
Route::get('/policies', [PageController::class, 'show'])->defaults('key', 'policies')->name('pages.policies');
Route::get('/contact', [PageController::class, 'show'])->defaults('key', 'contact')->name('pages.contact');

Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/{slug}', [RoomController::class, 'show'])->name('rooms.show');

Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/attractions', [AttractionController::class, 'index'])->name('attractions.index');
Route::get('/attractions/{slug}', [AttractionController::class, 'show'])->name('attractions.show');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

Route::get('/booking', [EnquiryController::class, 'create'])->name('booking.create');
Route::post('/enquiries', [EnquiryController::class, 'store'])->name('enquiries.store');
Route::get('/enquiry/thank-you', [EnquiryController::class, 'thankYou'])->name('enquiry.thankyou');

Route::get('/search', [SearchController::class, 'index'])->name('search.index');

Route::post('/booking/direct', [BookingController::class, 'store'])->name('booking.store');
Route::post('/booking/ota', [BookingController::class, 'otaRedirect'])->name('booking.ota');
Route::get('/booking/thank-you', [BookingController::class, 'thankYou'])->name('booking.thankyou');

Route::post('/external-bookings', [ExternalBookingController::class, 'store'])->name('external-bookings.store');

Route::post('/analytics/track', [AnalyticsController::class, 'store'])->name('analytics.track');

Route::get('/sitemap.xml', function () {
    return response()->view('public.sitemap')->header('Content-Type', 'application/xml');
})->name('sitemap');

Route::get('/robots.txt', function () {
    return response()->view('public.robots')->header('Content-Type', 'text/plain');
})->name('robots');

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin,editor'])
    ->group(function (): void {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::get('/settings', [AdminSettingsController::class, 'edit'])->name('settings.edit');
        Route::post('/settings', [AdminSettingsController::class, 'update'])->name('settings.update');

        Route::get('/pages', [AdminPageController::class, 'index'])->name('pages.index');
        Route::get('/pages/{page}/edit', [AdminPageController::class, 'edit'])->name('pages.edit');
        Route::put('/pages/{page}', [AdminPageController::class, 'update'])->name('pages.update');
        Route::post('/pages/{page}/sections/reorder', [AdminPageSectionController::class, 'reorder'])->name('pages.sections.reorder');

        Route::get('/pages/{page}/sections/create', [AdminPageSectionController::class, 'create'])->name('pages.sections.create');
        Route::post('/pages/sections', [AdminPageSectionController::class, 'store'])->name('pages.sections.store');
        Route::get('/pages/{page}/sections/{section}/edit', [AdminPageSectionController::class, 'edit'])->name('pages.sections.edit');
        Route::put('/pages/{page}/sections/{section}', [AdminPageSectionController::class, 'update'])->name('pages.sections.update');
        Route::delete('/pages/{page}/sections/{section}', [AdminPageSectionController::class, 'destroy'])->name('pages.sections.destroy');

        Route::resource('rooms', AdminRoomController::class);
        Route::resource('amenities', AdminAmenityController::class)->except(['show']);
        Route::resource('rates', AdminRateController::class)->except(['show']);
        Route::resource('gallery', AdminGalleryController::class)->except(['show']);
        Route::resource('media', AdminMediaController::class)->only(['index', 'store', 'destroy']);
        Route::post('gallery/{gallery}/images', [AdminGalleryController::class, 'storeImage'])->name('gallery.images.store');
        Route::delete('gallery/images/{image}', [AdminGalleryController::class, 'destroyImage'])->name('gallery.images.destroy');
        Route::resource('attractions', AdminAttractionController::class)->except(['show']);
        Route::resource('testimonials', AdminTestimonialController::class)->except(['show']);

        Route::get('enquiries/export', [AdminEnquiryController::class, 'export'])->name('enquiries.export');
        Route::get('enquiries/{enquiry}', [AdminEnquiryController::class, 'show'])->name('enquiries.show');
        Route::post('enquiries/{enquiry}/status', [AdminEnquiryController::class, 'updateStatus'])->name('enquiries.status');
        Route::get('enquiries', [AdminEnquiryController::class, 'index'])->name('enquiries.index');

        Route::get('external-bookings/export', [AdminExternalBookingController::class, 'export'])->name('external-bookings.export');
        Route::get('external-bookings/{externalBooking}', [AdminExternalBookingController::class, 'show'])->name('external-bookings.show');
        Route::post('external-bookings/{externalBooking}/status', [AdminExternalBookingController::class, 'updateStatus'])->name('external-bookings.status');
        Route::get('external-bookings', [AdminExternalBookingController::class, 'index'])->name('external-bookings.index');

        Route::get('bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
        Route::get('bookings/export', [AdminBookingController::class, 'export'])->name('bookings.export');
        Route::get('bookings/create', [AdminBookingController::class, 'create'])->name('bookings.create');
        Route::post('bookings', [AdminBookingController::class, 'store'])->name('bookings.store');
        Route::get('bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
        Route::post('bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.status');

        Route::get('booking-blocks', [AdminBookingBlockController::class, 'index'])->name('booking-blocks.index');
        Route::post('booking-blocks', [AdminBookingBlockController::class, 'store'])->name('booking-blocks.store');
        Route::delete('booking-blocks/{bookingBlock}', [AdminBookingBlockController::class, 'destroy'])->name('booking-blocks.destroy');

        Route::resource('blog', AdminBlogController::class)->parameters(['blog' => 'blog'])->except(['show']);
        Route::resource('blog-categories', AdminBlogCategoryController::class)->except(['show']);

        Route::middleware('role:admin')->group(function (): void {
            Route::resource('users', AdminUserController::class)->except(['show']);
        });
    });
