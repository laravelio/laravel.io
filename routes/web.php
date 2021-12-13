<?php

use App\Http\Controllers\Admin\ArticlesController as AdminArticlesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Articles\ArticlesController;
use App\Http\Controllers\Articles\AuthoredArticles;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\GithubController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Forum\TagsController;
use App\Http\Controllers\Forum\ThreadsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReplyAbleController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController as ProfileSettingsController;
use App\Http\Controllers\SocialImageController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

Route::feeds();

// Home
Route::get('/', [HomeController::class, 'show'])->name('home');
Route::view('rules', 'rules')->name('rules');
Route::view('terms', 'terms')->name('terms');
Route::view('privacy', 'privacy')->name('privacy');
Route::get('bin/{paste?}', [HomeController::class, 'pastebin']);

Route::get('articles/{article}/social.png', SocialImageController::class)->name('articles.image');

// Authentication
Route::namespace('Auth')->group(function () {
    // Sessions
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.post');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Registration
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register'])->name('register.post');

    // Password reset
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.forgot');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.forgot.post');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.reset.post');

    // Email address verification
    Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

    // Social authentication
    Route::get('login/github', [GithubController::class, 'redirectToProvider'])->name('login.github');
    Route::get('auth/github', [GithubController::class, 'handleProviderCallback']);
});

// Users
Route::redirect('/dashboard', '/user');
Route::get('user/{username?}', [ProfileController::class, 'show'])->name('profile');

// Notifications
Route::view('notifications', 'users.notifications')->name('notifications')->middleware(Authenticate::class);

// Settings
Route::get('settings', [ProfileSettingsController::class, 'edit'])->name('settings.profile');
Route::put('settings', [ProfileSettingsController::class, 'update'])->name('settings.profile.update');
Route::delete('settings', [ProfileSettingsController::class, 'destroy'])->name('settings.profile.delete');
Route::put('settings/password', [PasswordController::class, 'update'])->name('settings.password.update');

// Forum
Route::prefix('forum')->group(function () {
    Route::get('/', [ThreadsController::class, 'overview'])->name('forum');
    Route::get('create-thread', [ThreadsController::class, 'create'])->name('threads.create');
    Route::post('create-thread', [ThreadsController::class, 'store'])->name('threads.store');

    Route::get('{thread}', [ThreadsController::class, 'show'])->name('thread');
    Route::get('{thread}/edit', [ThreadsController::class, 'edit'])->name('threads.edit');
    Route::put('{thread}', [ThreadsController::class, 'update'])->name('threads.update');
    Route::delete('{thread}', [ThreadsController::class, 'delete'])->name('threads.delete');
    Route::put('{thread}/mark-solution/{reply}', [ThreadsController::class, 'markSolution'])->name('threads.solution.mark');
    Route::put('{thread}/unmark-solution', [ThreadsController::class, 'unmarkSolution'])->name('threads.solution.unmark');
    Route::get('{thread}/subscribe', [ThreadsController::class, 'subscribe'])->name('threads.subscribe');
    Route::get('{thread}/unsubscribe', [ThreadsController::class, 'unsubscribe'])->name('threads.unsubscribe');

    Route::get('tags/{tag}', [TagsController::class, 'show'])->name('forum.tag');
});

// Replies
Route::post('replies', [ReplyController::class, 'store'])->name('replies.store');
Route::get('replies/{reply}/edit', [ReplyController::class, 'edit'])->name('replies.edit');
Route::put('replies/{reply}', [ReplyController::class, 'update'])->name('replies.update');
Route::delete('replies/{reply}', [ReplyController::class, 'delete'])->name('replies.delete');
Route::get('replyable/{id}/{type}', [ReplyAbleController::class, 'redirect'])->name('replyable');

// Subscriptions
Route::get('subscriptions/{subscription}/unsubscribe', [SubscriptionController::class, 'unsubscribe'])
    ->name('subscriptions.unsubscribe');

// Articles
Route::prefix('articles')->group(function () {
    Route::get('authored', AuthoredArticles::class)->name('user.articles');
    Route::get('/', [ArticlesController::class, 'index'])->name('articles');
    Route::get('create', [ArticlesController::class, 'create'])->name('articles.create');
    Route::post('/', [ArticlesController::class, 'store'])->name('articles.store');
    Route::get('{article}', [ArticlesController::class, 'show'])->name('articles.show');
    Route::get('{article}/edit', [ArticlesController::class, 'edit'])->name('articles.edit');
    Route::put('{article}', [ArticlesController::class, 'update'])->name('articles.update');
    Route::delete('{article}', [ArticlesController::class, 'delete'])->name('articles.delete');
});

// Admin
Route::prefix('admin')->name('admin')->group(function () {
    Route::get('/', [AdminArticlesController::class, 'index']);

    // Users
    Route::get('users', [UsersController::class, 'index'])->name('.users');
    Route::put('users/{username}/ban', [UsersController::class, 'ban'])->name('.users.ban');
    Route::put('users/{username}/unban', [UsersController::class, 'unban'])->name('.users.unban');
    Route::delete('users/{username}', [UsersController::class, 'delete'])->name('.users.delete');

    // Articles
    Route::put('articles/{article}/approve', [AdminArticlesController::class, 'approve'])->name('.articles.approve');
    Route::put('articles/{article}/disapprove', [AdminArticlesController::class, 'disapprove'])->name('.articles.disapprove');
    Route::put('articles/{article}/decline', [AdminArticlesController::class, 'decline'])->name('.articles.decline');
    Route::put('articles/{article}/pinned', [AdminArticlesController::class, 'togglePinnedStatus'])->name('.articles.pinned');
});
