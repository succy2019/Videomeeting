<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MeetingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/add', function () {
    return view('addmeeting');
})->middleware(['auth', 'verified']);
Route::get('meetings/{id}/start', [MeetingController::class, 'start'])->middleware(['auth', 'verified'])->name('meetings.start');
Route::get('meetings/{id}/join', [MeetingController::class, 'join'])->middleware(['auth', 'verified'])->name('meetings.join');
Route::post('/add', [MeetingController::class,'store'])->middleware(['auth', 'verified'])->name('store.meeting');

Route::get('/dashboard', [MeetingController::class,'showAll'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
