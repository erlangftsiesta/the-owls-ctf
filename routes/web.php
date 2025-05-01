<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\FlagQuestionController;
use App\Http\Controllers\FlagTypeController;

// Route Login dan Logout
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/', [HomepageController::class, 'index'])->name('homepage');

// Admin route
Route::prefix('admin/question_flag')->name('admin.question_flag.')->group(function () {
    Route::get('/', [FlagQuestionController::class, 'index'])->name('index');
    Route::get('/create', [FlagQuestionController::class, 'create'])->name('create');
    Route::post('/', [FlagQuestionController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [FlagQuestionController::class, 'edit'])->name('edit');
    Route::put('/{id}', [FlagQuestionController::class, 'update'])->name('update');
    Route::delete('/{id}', [FlagQuestionController::class, 'destroy'])->name('destroy');
});

Route::resource('admin/flag_type', FlagTypeController::class)->names('admin.flag_type');


// Route yang butuh auth
Route::middleware(['auth'])->group(function () {
    Route::resource('user', UsersController::class);
    // List challenges by type
    Route::get('/challenge/{type}', [FlagQuestionController::class, 'listByType'])
        ->name('challenge.list');
    
    // Show a specific challenge
    Route::get('/challenge/{type}/{id}', [FlagQuestionController::class, 'show'])
        ->name('challenge.show');
    
    // Submit a flag for a challenge
    Route::post('/challenge/{type}/{id}/submit', [FlagQuestionController::class, 'submitFlag'])
        ->name('challenge.submit');
});
