<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaptopImportController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/import-laptops', [LaptopImportController::class, 'showForm'])->name('laptops.import.form');
Route::post('/import-laptops', [LaptopImportController::class, 'import'])->name('laptops.import');
