<?php

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
