<?php

require __DIR__.'/auth.php';

use App\Http\Controllers\Admin\TemplateController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('wellcome');

Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/terms', 'terms')->name('terms');

Route::get('/dashboard', [ServiceController::class, 'index'])
->middleware(['auth', 'verified'])
->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// PUBLIC/AUTH ROUTES (Anyone logged in)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [ServiceController::class, 'index'])->name('dashboard');
    Route::post('/order/{id}', [ServiceController::class, 'store'])->name('order.store');
});

// ADMIN ONLY ROUTES (Only you)
Route::middleware(['auth', 'admin'])->group(function () {
    // This covers create, store, edit, update, and destroy
    Route::resource('templates', TemplateController::class);

    // Your specific admin dashboard for viewing all orders
    Route::get('/admin/orders', [ServiceController::class, 'adminIndex'])->name('admin.orders');
    Route::patch('/admin/orders/{id}/status', [ServiceController::class, 'updateStatus'])->name('admin.orders.update');
});
