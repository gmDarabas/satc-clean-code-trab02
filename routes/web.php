<?php

use App\Http\Controllers\PastaController;
use App\Http\Controllers\TorrentController;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/', [TorrentController::class, 'index'])->name('torrents.index');
Route::get('/torrents', [TorrentController::class, 'index'])->name('torrents.index');
Route::get('/torrents/{arquivo}', [TorrentController::class, 'show'])->name('torrents.show');
Route::get('/torrents/{arquivo}/download', [TorrentController::class, 'download'])->name('torrents.download');

Route::middleware('auth')->group(function () {
    Route::get('/torrents/create', [TorrentController::class, 'create'])->name('torrents.create');
    Route::post('/torrents', [TorrentController::class, 'store'])->name('torrents.store');
    Route::get('/torrents/{arquivo}/edit', [TorrentController::class, 'edit'])->name('torrents.edit');
    Route::put('/torrents/{arquivo}', [TorrentController::class, 'update'])->name('torrents.update');
    Route::delete('/torrents/{arquivo}', [TorrentController::class, 'destroy'])->name('torrents.destroy');
});

Route::get('/pastas', [PastaController::class, 'index'])->name('pastas.index');
Route::get('/pastas/{pasta}', [PastaController::class, 'show'])->name('pastas.show');

Route::middleware('auth')->group(function () {
    Route::get('/pastas/create', [PastaController::class, 'create'])->name('pastas.create');
    Route::post('/pastas', [PastaController::class, 'store'])->name('pastas.store');
    Route::get('/pastas/{pasta}/edit', [PastaController::class, 'edit'])->name('pastas.edit');
    Route::put('/pastas/{pasta}', [PastaController::class, 'update'])->name('pastas.update');
    Route::delete('/pastas/{pasta}', [PastaController::class, 'destroy'])->name('pastas.destroy');
});
