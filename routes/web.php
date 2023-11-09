<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\NotificationSeenController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    $userRole = $user->roles->first()->name ?? null;
    $userPermissions = $user->getAllPermissions()->pluck('name')->toArray() ?? null; // Use Spatie's method to get permission names

    return Inertia::render('Dashboard', [
        'userRole' => $userRole,
        'userPermissions' => $userPermissions,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::resource('images', ImageController::class);

Route::get('image', [ImageController::class, 'index'])->name('image.index');
Route::get('image/create', [ImageController::class, 'create'])->name('image.create');
Route::post('image', [ImageController::class, 'store'])->name('image.store');

Route::get('/users', UserController::class)->name('users');



Route::resource('blogs', BlogController::class);

Route::resource('author', AuthorController::class);
Route::resource('genre', GenreController::class);

Route::resource('books', BookController::class);
Route::resource('report', ReportController::class);

Route::resource('notification', NotificationController::class)->middleware('auth')->only(['index']);

Route::put('notification/{notification}/seen', NotificationSeenController::class)->middleware('auth')->name('notification.seen');

require __DIR__ . '/auth.php';
