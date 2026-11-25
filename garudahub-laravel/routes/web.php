<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BidController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RatingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('projects', ProjectController::class);

    Route::post('/projects/{project}/bids', [BidController::class, 'store'])->name('bids.store');
    Route::post('/bids/{bid}/accept', [BidController::class, 'accept'])->name('bids.accept');

    Route::get('/projects/{project}/rating', [RatingController::class, 'create'])->name('ratings.create');
    Route::post('/projects/{project}/rating', [RatingController::class, 'store'])->name('ratings.store');
});