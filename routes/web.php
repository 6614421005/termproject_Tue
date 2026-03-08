<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 1. กลุ่มที่ต้อง Login (ใส่ไว้ก่อนเพื่อให้ Laravel เช็คสิทธิ์ก่อนเข้าถึงหน้าฟอร์ม)
Route::middleware(['auth'])->group(function () {
    // ให้สร้างเฉพาะตัวที่ต้องการสิทธิ์ (create, store, edit, update, destroy)
    Route::resource('cards', CardController::class)->except(['index', 'show']);
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 2. กลุ่มที่คนทั่วไปดูได้ (ย้ายมาไว้ข้างล่าง)
Route::resource('cards', CardController::class)->only(['index', 'show']);

require __DIR__.'/auth.php';
require __DIR__.'/settings.php';