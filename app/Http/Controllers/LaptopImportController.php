<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\LaptopsImport;
use Maatwebsite\Excel\Facades\Excel;

class LaptopImportController extends Controller
{
    public function showForm()
    {
        return view('import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|file|mimes:xlsx,xls',
        ]);

        $file = $request->file('file_excel'); // pastikan ini adalah UploadedFile

        Excel::import(new LaptopsImport, $file);

        return back()->with('success', 'Import berhasil.');
    }
}
