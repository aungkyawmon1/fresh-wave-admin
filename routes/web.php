<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::controller(LoginController::class)->group(function() {
    Route::get('/login', 'show')->name('login');
    Route::post('/login', 'login')->name('portal-login');
    Route::get('/register', 'register_show')->name('portal-register');
    Route::post('/register', 'register')->name('register');
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(DashboardController::class)->group(function() {
    Route::get('/dashboard', 'dashboard')->name('dashboard');
});

Route::controller(AgentController::class)->group(function() {
    Route::get('/agents', 'view')->name('agents');
    Route::get('/agent-form', 'add_form')->name('add-form');
    Route::post('/agent-add', 'add')->name('agent-add');
    Route::get('/agents/{agent}/edit', 'edit_form')->name('agent-edit');
    Route::get('/agents/{agent}/delete', 'delete')->name('agent-delete');
// updates a post
Route::post('/agent-edit-submit', 'edit')->name('agent-edit-submit');
});

Route::controller(StockController::class)->group(function() {
    Route::get('/stocks', 'view')->name('stocks');
    Route::get('/stocks/{stock}/edit', 'add_stock_form')->name('stock-edit');
// updates a post
    Route::post('/stock-edit-submit', 'add_stock')->name('stock-edit-submit');
});

Route::controller(PostController::class)->group(function() {
    Route::get('/posts', 'view')->name('posts');
    Route::get('/post-form', 'add_form')->name('post-form');
    Route::post('/post-add', 'add')->name('post-add');
    Route::get('/posts/{post}/edit', 'edit_form')->name('post-edit');
    Route::get('/post/{post}/delete', 'delete')->name('post-delete');
// updates a post
Route::post('/post-edit-submit', 'edit')->name('post-edit-submit');
});