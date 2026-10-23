<?php

use App\Http\Controllers\Admin\CastController as AdminCastController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\KritikController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FilmController::class, 'movieHome'])->name('home');
Route::get('/movies', [FilmController::class, 'movies'])->name('movies');
Route::get('/movies/{film}', [FilmController::class, 'show'])->name('movies.show');
Route::get('/movies/genre/{genre}', [FilmController::class, 'moviesByGenre'])->name('genre');
Route::post('/movies/{film}/reviews', [KritikController::class, 'store'])
    ->middleware('auth')
    ->name('movies.reviews.store');
Route::post('/subscribe', [SubscriptionController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('subscriptions.store');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/profile', [ProfileController::class, 'showMine'])
    ->middleware('auth')
    ->name('profile.me');
Route::get('/profile/edit', [ProfileController::class, 'editMine'])
    ->middleware('auth')
    ->name('profile.edit');
Route::put('/profile', [ProfileController::class, 'updateMine'])
    ->middleware('auth')
    ->name('profile.update');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('films', App\Http\Controllers\Admin\FilmController::class)->except('show');
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::delete('/reviews/{kritik}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::resource('casts', AdminCastController::class)->except('show');
    Route::get('/subscribers', [SubscriberController::class, 'index'])->name('subscribers.index');
});
