<?php

use App\Http\Controllers\pegawaiController;
use App\Http\Controllers\surat_tugasController;
use Illuminate\Support\Facades\Route;

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
Route::get('/surat-tugas/create', [surat_tugasController::class, 'create'])->name('surat_tugas.create');
Route::post('/surat-tugas', [surat_tugasController::class, 'store'])->name('surat_tugas.store');
Route::get('/search-cities', [surat_tugasController::class, 'searchCities']);
Route::get('/pegawai/suggestions', [surat_tugasController::class, 'getSuggestions']);
Route::post('/pegawai/add', [surat_tugasController::class, 'store_pd']);

Route::get('/pegawai/data', [PegawaiController::class, 'getData'])->name('pegawai.data');
Route::get('/pegawai', [pegawaiController::class, 'index'])->name('pegawai.index');
Route::get('/pegawai/create', [PegawaiController::class, 'create'])->name('pegawai.create');
Route::post('/pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');
Route::get('/pegawai/{pegawai}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
Route::put('/pegawai/{pegawai}', [PegawaiController::class, 'update'])->name('pegawai.update');
Route::delete('/pegawai/{pegawai}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');