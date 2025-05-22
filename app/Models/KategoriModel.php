<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriModel extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'kategori';

    protected $fillable = ['nama_kategori'];

    // Relasi ke aset-aset lain jika dibutuhkan
    public function laptops()
    {
        return $this->hasMany(LaptopModel::class);
    }

    // public function printers()
    // {
    //     return $this->hasMany(Printer::class);
    // }
}
