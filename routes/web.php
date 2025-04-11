<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PesananController;
use App\Http\Controllers\JadwalController;


Route::get('/', [PesananController::class, 'index'])->name('pesanan.index');
Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
Route::get('/pesanan/create', [PesananController::class, 'create'])->name('pesanan.create');
Route::post('/pesanan/store', [PesananController::class, 'store'])->name('pesanan.store');
Route::get('/pesanan/edit/{id}', [PesananController::class, 'edit'])->name('pesanan.edit');
Route::put('/pesanan/{id}', [PesananController::class, 'update'])->name('pesanan.update');
Route::delete('/pesanan/{id}', [PesananController::class, 'destroy'])->name('pesanan.destroy');

