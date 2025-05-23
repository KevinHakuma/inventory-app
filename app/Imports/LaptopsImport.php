<?php

namespace App\Imports;

use App\Models\CabangModel;
use App\Models\LaptopModel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LaptopsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Ambil dan olah nama cabang dari Excel
        $rowCabangName = trim($row['cabang']);

        // Jika ada "=" ambil hanya bagian pertama (misalnya "HO = MKG" → "HO")
        if (str_contains($rowCabangName, '=')) {
            $rowCabangName = trim(explode('=', $rowCabangName)[0]);
        }

        // Cari cabang berdasarkan kode_cabang
        $cabang = CabangModel::where('kode_cabang', 'like', "%{$rowCabangName}%")->first();

        // Jika tidak ketemu, cabang_id diisi null
        $cabangId = $cabang ? $cabang->id : null;

        return new LaptopModel([
            'jenis'       => $row['jenis'],
            'nama_aset'   => $row['nama_aset'],
            'kode_aset'   => $row['kode_aset'],
            'kategori_id' => $row['kategori_id'],
            'cabang_id'   => $cabangId,
            'merek'       => $row['merek'],
            'processor'   => $row['processor'],
            'ram'         => $row['ram'],
            'storage'     => $row['storage'],
            'kondisi'     => $row['kondisi'],
            'user'        => $row['user'],
        ]);
    }
}
