<?php

use Illuminate\Support\Facades\Route;
use App\Events\TestEnvent;
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
Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home.index');
Route::get('/class', [\App\Http\Controllers\HomeController::class, 'class'])->name('home.class');
Route::get('/exams/{class_id}', [\App\Http\Controllers\HomeController::class, 'exams'])->name('home.exams');
Route::get('/exam-detail/{url_id}', [\App\Http\Controllers\HomeController::class, 'exam_detail'])->name('home.exam_detail');
Route::get('/doing/{exam}', [\App\Http\Controllers\HomeController::class, 'doing'])->name('home.doing');
Route::get('/finish/{exam}', [\App\Http\Controllers\HomeController::class, 'finish'])->name('home.finish');
Route::get('/form', [\App\Http\Controllers\HomeController::class, 'form'])->name('form');
Route::post('/post/form', [\App\Http\Controllers\HomeController::class, 'PostForm'])->name('post-form');

Route::get('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::get('/login/google', [\App\Http\Controllers\AuthController::class, 'redirectToGoogle'])->name('redirectToGoogle');
Route::get('/login/google/callback', [\App\Http\Controllers\AuthController::class, 'googleSignin'])->name('googleSignin');

Route::get('/login/facebook', [\App\Http\Controllers\AuthController::class, 'redirectToFacebook'])->name('redirectToFacebook');
Route::get('/login/facebook/callback', [\App\Http\Controllers\AuthController::class, 'facebookSignin'])->name('facebookSignin');

Route::get('/test', [\App\Http\Controllers\Test2Controller::class, 'index']);

Route::get('/check', function(){
    $user = \App\Models\User::find(1);

    broadcast(new \App\Events\ServerCreated($user));
});


