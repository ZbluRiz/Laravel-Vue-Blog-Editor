<?php

use App\Http\Controllers\Admin\PostAdminController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\blogEditorController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// route edit profile dari breeze
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// route untuk melakukan post ke post model
Route::middleware('auth')->group(function () {
    Route::get('/blogs', [blogEditorController::class, 'index'])->name('blogs');
    Route::post('/blog', [blogEditorController::class, 'store'])->name('blogs.store');
    Route::get('/blogs/{blog}/edit', [blogEditorController::class, 'edit'])->name('blogs.edit');
    Route::put('/blogs/{blog}', [blogEditorController::class, 'update'])->name('blogs.update');
    Route::delete('/blogs/{post}', [blogEditorController::class, 'destroy'])->name('blogs.destroy');
    Route::get('/blog-editor/create', function () {
        return Inertia::render('Blogs/BlogEditor');
    });

    // comments & likes
    Route::post('/blogs/{post}/comments', [CommentController::class, 'store'])->name('blogs.comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/blogs/{post}/likes/toggle', [LikeController::class, 'toggle'])->name('blogs.likes.toggle');
});

// Admin dashboard - only for admin role
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/posts', [PostAdminController::class, 'index'])
        ->middleware('can:viewAny,' . \App\Models\Post::class)
        ->name('admin.posts.index');
    Route::delete('/admin/posts/{post}', [PostAdminController::class, 'destroy'])
        ->middleware('can:delete,post')
        ->name('admin.posts.destroy');
});

    
require __DIR__ . '/auth.php';
