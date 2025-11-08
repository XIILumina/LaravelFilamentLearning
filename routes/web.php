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
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostLikeController;
use App\Http\Controllers\CommentLikeController;
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

    // Blog routes
    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    
    Route::middleware(['auth'])->group(function () {
        // Blog management
        Route::get('/blog/create', [BlogController::class, 'create'])->name('blog.create');
        Route::post('/blog', [BlogController::class, 'store'])->name('blog.store');
        Route::get('/blog/{post}/edit', [BlogController::class, 'edit'])->name('blog.edit');
        Route::put('/blog/{post}', [BlogController::class, 'update'])->name('blog.update');
        Route::delete('/blog/{post}', [BlogController::class, 'destroy'])->name('blog.destroy');
        
        // Comments
        Route::post('/blog/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
        Route::put('/blog/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
        Route::delete('/blog/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
        
        // Likes
        Route::post('/blog/posts/{post}/like', [PostLikeController::class, 'toggle'])->name('posts.like');
        Route::post('/blog/comments/{comment}/like', [CommentLikeController::class, 'toggle'])->name('comments.like');
    });
    
    Route::get('/blog/{post}', [BlogController::class, 'show'])->name('blog.show');
    
    // Communities routes
    Route::get('/communities', [CommunityController::class, 'index'])->name('communities.index');
    Route::get('/community/{community}', [CommunityController::class, 'show'])->name('communities.show');
    Route::get('/community/{community}/{post}', [CommunityController::class, 'showPost'])->name('communities.post');
    
    // Community subscription routes (auth required)
    Route::middleware(['auth'])->group(function () {
        Route::post('/community/{community}/subscribe', [CommunityController::class, 'subscribe'])->name('communities.subscribe');
        Route::delete('/community/{community}/unsubscribe', [CommunityController::class, 'unsubscribe'])->name('communities.unsubscribe');
        Route::patch('/community/{community}/notifications', [CommunityController::class, 'updateNotifications'])->name('communities.notifications');
    });

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
