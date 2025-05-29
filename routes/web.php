<?php

use App\Http\Controllers\TorrentController;
use Illuminate\Support\Facades\Route;

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
