<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Home\AboutController;
use App\Http\Controllers\Home\HomeSliderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::controller(HomeController::class)->group(function(){
    Route::get('/', 'index')->name('front.index');
});

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




// ----------------------- Start of Admin Route ------------------------
Route::middleware('auth')->group(function(){

    Route::controller(AdminController::class)->group(function(){
        Route::get('/admin/logout', 'destroy')->name('admin.logout');
        Route::get('/admin/profile', 'profile')->name('admin.profile');
        Route::get('/admin/edit-profile', 'editProfile')->name('admin.edit_profile');
        Route::post('/admin/store-profile', 'storeProfile')->name('admin.store_profile');
        Route::get('change-password', 'changePassword')->name('change.password');
        Route::post('/update-password', 'updatePassword')->name('update.password');
    });

    // Home slide routes
    Route::controller(HomeSliderController::class)->group(function(){
        Route::get('/home/slider', 'homeSlider')->name('home.slide');
        Route::put('/update/home/slide/{slide}', 'updateHomeSlide')->name('home_slide.update');
    });

    // About page routes
    Route::controller(AboutController::class)->group(function(){
        Route::get('/about/slide', 'aboutPage')->name('about.page');
        Route::put('/about/update/{about}', 'updateAbout')->name('about.update');
        Route::get('/about', 'homeAbout')->name('home.about');

        Route::get('/about/multi/image', 'aboutMultiImage')->name('about.multi_image');
        Route::post('/about/store/multi_image', 'storeMultiImage')->name('about.store_multi_image');
        Route::get('/about/all-multi_image', 'allMultiImage')->name('all.multi_image');
        Route::get('/about/edit-multi-image/{multiImage}', 'editMultiImage')->name('edit.multi_image');
        Route::put('/about/update/multi-image/{multiImage}', 'updateMultiImage')->name('update.multi_image');
        Route::get('/about/delete/multi-image/{multiImage}', 'deleteMultiImage')->name('delete.multi_image');
    });
});

// ----------------------- End of Admin Route ------------------------





require __DIR__.'/auth.php';
