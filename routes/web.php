<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FoodSpotController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SellerDashboardController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\SavedSpotController;
use App\Http\Controllers\VisitedSpotController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VisitRequestController;


Route::get('/', [FoodSpotController::class, 'index'])->name('home');
Route::get('/spots', [FoodSpotController::class, 'index'])->name('spots.index');
Route::get('/spots/{foodSpot}', [FoodSpotController::class, 'show'])->name('spots.show');
Route::get('/spots/{foodSpot}/weather', [FoodSpotController::class, 'weather'])->name('spots.weather');
// AJAX search
Route::get('/spots-search', [FoodSpotController::class, 'ajaxSearch'])->name('spots.ajax');
Route::get('/feed', [FoodSpotController::class, 'feed'])->name('feed');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile routes (Breeze default)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Reviews
    Route::post('/spots/{foodSpot}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::post('/reviews/{review}/flag', [ReviewController::class, 'flag'])->name('reviews.flag');
    Route::post('/reviews/{review}/reply', [ReviewController::class, 'reply'])->name('reviews.reply');
    Route::post('/spots/{foodSpot}/visit-requests', [VisitRequestController::class, 'store'])->name('visit-requests.store');

    // Saved spots
    Route::get('/saved', [SavedSpotController::class, 'index'])->name('saved.index');
    Route::post('/saved/{foodSpot}', [SavedSpotController::class, 'store'])->name('saved.store');
    Route::delete('/saved/{foodSpot}', [SavedSpotController::class, 'destroy'])->name('saved.destroy');
    Route::post('/visited-spots', [VisitedSpotController::class, 'store'])->name('visited-spots.store');

    // Seller routes
    Route::prefix('seller')->name('seller.')->middleware('role:seller')->group(function () {
        Route::get('/dashboard', [SellerDashboardController::class, 'index'])->name('dashboard');
        Route::get('/reviews', [SellerDashboardController::class, 'reviews'])->name('reviews.index');
        Route::get('/visit-requests', [SellerDashboardController::class, 'visitRequests'])->name('visit_requests.index');
        Route::get('/spots/create', [SellerDashboardController::class, 'create'])->name('spots.create');
        Route::post('/spots', [SellerDashboardController::class, 'store'])->name('spots.store');
        Route::get('/spots/{foodSpot}/edit', [SellerDashboardController::class, 'edit'])->name('spots.edit');
        Route::put('/spots/{foodSpot}', [SellerDashboardController::class, 'update'])->name('spots.update');
        Route::delete('/spots/{foodSpot}', [SellerDashboardController::class, 'destroy'])->name('spots.destroy');
        Route::post('/spots/{foodSpot}/menu-items', [SellerDashboardController::class, 'addMenuItem'])->name('menu.store');
        Route::post('/spots/{foodSpot}/photos', [SellerDashboardController::class, 'addPhoto'])->name('photos.store');
        Route::delete('/menu-items/{menuItem}', [SellerDashboardController::class, 'deleteMenuItem'])->name('menu.destroy');
    });

    // Admin routes
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/spots/{foodSpot}/detail', [AdminDashboardController::class, 'detail'])->name('spots.detail');
        Route::post('/spots/{foodSpot}/approve', [AdminDashboardController::class, 'approveSpot'])->name('spots.approve');
        Route::delete('/spots/{foodSpot}', [AdminDashboardController::class, 'deleteSpot'])->name('spots.delete');
        Route::delete('/reviews/{review}', [AdminDashboardController::class, 'deleteReview'])->name('reviews.delete');
        Route::post('/categories', [AdminDashboardController::class, 'storeCategory'])->name('categories.store');
    });

});

require __DIR__.'/auth.php';