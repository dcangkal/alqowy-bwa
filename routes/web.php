<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseVideoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubcribeTransactionController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontController::class, 'index'])->name('front.index');
Route::get('/details/{course:slug}', [FrontController::class, 'details'])->name('front.details');
Route::get('/category/{category:slug}', [FrontController::class, 'category'])->name('front.category');
Route::get('/pricing', [FrontController::class, 'pricing'])->name('front.pricing');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/checkout', [FrontController::class, 'checkout'])->name('front.checkout')->middleware('role:student');
    Route::post('/checkout/store', [FrontController::class, 'checkoutStore'])->name('front.checkout.store')->middleware('role:student');

    Route::get('/learning/{course}/{courseVideoId}', [FrontController::class, 'learning'])->name('front.learning')->middleware('role:student|teacher|owner');

    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('categories',CategoryController::class)->middleware('role:owner');
        Route::resource('teachers',TeacherController::class)->middleware('role:owner');
        Route::resource('courses',CourseController::class)->middleware('role:owner|teacher');
        Route::resource('subcribe_transactions',SubcribeTransactionController::class)->middleware('role:owner');
        Route::get('/add/video/{course:id}',[CourseVideoController::class,'create'])->middleware('role:owner|teacher')->name('course.add_video');
        Route::post('/add/video/save/{course:id}',[CourseVideoController::class,'store'])->middleware('role:owner|teacher')->name('course.add_video.save');
        Route::resource('course_videos',CourseVideoController::class)->middleware('role:owner|teacher');
    });

});

require __DIR__.'/auth.php';