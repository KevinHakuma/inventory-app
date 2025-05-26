<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaptopImportController;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/import-laptops', [LaptopImportController::class, 'showForm'])->name('laptops.import.form');
Route::post('/import-laptops', [LaptopImportController::class, 'import'])->name('laptops.import');
Route::get('/export-laptop', [\App\Http\Controllers\LaptopExportController::class, 'export']);
