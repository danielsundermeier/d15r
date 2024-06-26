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

Route::get('/', [ App\Http\Controllers\WelcomeController::class, 'index' ])->name('home');

Route::get('/impressum', function () {
    return view('impressum');
})->name('impressum');

Route::get('/contact', [ App\Http\Controllers\ContactController::class, 'index' ])->name('contact.index');
Route::post('/contact', [ App\Http\Controllers\ContactController::class, 'store' ])->name('contact.store');

Route::post('/blog/deploy', [ App\Http\Controllers\Posts\DeploymentController::class, 'store' ])->name('posts.deploy.store');

Route::get('/about', [ App\Http\Controllers\AboutController::class, 'index' ])->name('about.index');

Route::get('/future/masterplan/{markdownfilename?}', [ App\Http\Controllers\Future\MasterplanController::class, 'show' ])->name('future.masterplan.show');
Route::get('/future/vision/{markdownfilename?}', [ App\Http\Controllers\Future\VisionController::class, 'show' ])->name('future.vision.show');

Route::get('/blog', [ App\Http\Controllers\Posts\PostController::class, 'index' ])->name('posts.index');
Route::get('/blog/{post:slug}', [ App\Http\Controllers\Posts\PostController::class, 'show' ])->name('posts.show');

Route::get('/guides', [ App\Http\Controllers\Guides\GuideController::class, 'index' ])->name('guides.index');
Route::get('/guides/{guide:slug}/{file?}', [ App\Http\Controllers\Guides\GuideController::class, 'show' ])->name('guides.show');

Route::get('/challenge', [ App\Http\Controllers\ChallengeController::class, 'index' ])->name('challenge.index');
Route::get('/how', [ App\Http\Controllers\HowController::class, 'index' ])->name('how.index');

// require __DIR__.'/auth.php';
