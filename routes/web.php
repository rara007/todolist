<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// Rute utama (homepage) akan redirect ke daftar To-Do List publik (/tasks)
Route::get('/', function () {
    return redirect()->route('tasks.index');
});

// Rute Dashboard: Ini adalah halaman dashboard bawaan Breeze ("You're logged in!")
// Hanya bisa diakses oleh pengguna yang sudah login
Route::get('/dashboard', function () {
    return view('dashboard'); // Mengembalikan ke view resources/views/dashboard.blade.php
})->middleware(['auth', 'verified'])->name('dashboard');

// Rute utama To-Do List (/tasks)
// Logika tampilan (promosi jika guest, personal list jika login) ditangani di TaskController@index
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');

// Grup rute yang memerlukan autentikasi (harus login)
Route::middleware('auth')->group(function () {
    // Rute profil (bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute CRUD Tasks (kecuali index dan show, karena sudah didefinisikan secara publik di atas)
    // create, store, edit, update, destroy memerlukan autentikasi
    Route::resource('tasks', TaskController::class)->except(['index', 'show']);
});

// Rute untuk melihat detail satu tugas (tasks/{task})
// Dapat diakses siapa saja (opsional, bisa juga dilindungi auth jika mau detail hanya untuk pemilik)
Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');

require __DIR__.'/auth.php'; // Ini mengimpor rute-rute autentikasi Breeze