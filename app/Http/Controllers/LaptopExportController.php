<?php

namespace App\Http\Controllers;

use App\Exports\LaptopExport;
use Maatwebsite\Excel\Facades\Excel;

class LaptopExportController extends Controller
{
    public function export()
    {
        // return Excel::download(new LaptopExport, 'laptop-export.xlsx');
        return Excel::download(new LaptopExport, 'laptop-export-' . now()->format('d-m-Y-H-i') . '.xlsx');
    }
}
