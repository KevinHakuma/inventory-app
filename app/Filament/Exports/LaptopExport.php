<?php

namespace App\Exports;

use App\Models\LaptopModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaptopExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return LaptopModel::with('cabang')
            ->get()
            ->map(function ($item) {
                return [
                    'jenis' => $item->jenis,
                    'nama_aset' => $item->nama_aset,
                    'kode_aset' => $item->kode_aset,
                    'merek' => $item->merek,
                    'processor' => $item->processor,
                    'ram' => $item->ram,
                    'storage' => $item->storage,
                    'kondisi' => $item->kondisi,
                    'user' => $item->user,
                    'cabang' => $item->cabang?->nama_cabang,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Jenis',
            'Nama Aset',
            'Kode Aset',
            'Merek',
            'Processor',
            'RAM',
            'Storage',
            'Kondisi',
            'User',
            'Cabang',
        ];
    }
}
