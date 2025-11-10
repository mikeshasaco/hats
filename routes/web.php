<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Hub\QRController;
use App\Http\Controllers\Hub\ClaimController;
use App\Http\Controllers\Admin\HatGenController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'));
Route::get('/app', fn() => view('apps.index'))->name('apps.index');
Route::get('/app/{city}', fn($city) => view('apps.city', ['city' => $city]))->name('apps.city');

Route::get('/h/{slug}', [QRController::class, 'show'])->name('hub.show');     // scan target
Route::post('/h/{slug}/claim', [ClaimController::class, 'claim'])
  ->middleware(['auth','throttle:6,1'])->name('hub.claim');

// simple admin endpoints (dev only)
Route::middleware(['auth'])->group(function(){
  Route::get('/admin/mint', [HatGenController::class, 'form'])->name('admin.mint.form');
  Route::post('/admin/mint', [HatGenController::class, 'mint'])->name('admin.mint');
  Route::get('/admin/qr/{slug}.{ext?}', [HatGenController::class, 'qr'])->where(['ext' => 'svg|png'])->name('admin.qr');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
