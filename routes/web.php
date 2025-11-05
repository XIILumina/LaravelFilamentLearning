<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\FrontObjectController;
use App\Http\Controllers\FrontGameController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\ContactController;


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('/objects', [FrontObjectController::class, 'index'])->name('objects.index');
    Route::get('/objects/{object}', [FrontObjectController::class, 'show'])->name('objects.show');

    Route::get('/games', [FrontGameController::class, 'index'])->name('games.index');
    Route::get('/games/{game}', [FrontGameController::class, 'show'])->name('games.show');

    Route::get('/genres', [GenreController::class, 'index'])->name('genres.index');
    Route::get('/genres/{genre}', [GenreController::class, 'show'])->name('genres.show');
    Route::get('/platforms', [PlatformController::class, 'index'])->name('platforms.index');

    Route::middleware(['auth'])->group(function () {
        Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
        Route::post('/wishlist/add/{game}', [WishlistController::class, 'store'])->name('wishlist.add');
        Route::delete('/wishlist/remove/{game}', [WishlistController::class, 'destroy'])->name('wishlist.remove');
    });

    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/community', [CommunityController::class, 'index'])->name('community.index');

    Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
    Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
