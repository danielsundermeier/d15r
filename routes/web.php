<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
})->name('home');

Route::get('/impressum', function () {
    return view('impressum');
})->name('impressum');

Route::post('/contact', [ App\Http\Controllers\ContactController::class, 'store' ])->name('contact.store');

Route::get('/blog', [ App\Http\Controllers\Posts\PostController::class, 'index' ])->name('posts.index');
Route::get('/blog/{post:slug}', [ App\Http\Controllers\Posts\PostController::class, 'show' ])->name('posts.show');

// require __DIR__.'/auth.php';
