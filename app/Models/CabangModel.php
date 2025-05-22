<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CabangModel extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'cabang';

    protected $fillable = ['nama_cabang', 'kode_cabang'];

    public function laptops()
    {
        return $this->hasMany(LaptopModel::class);
    }

    // public function printers()
    // {
    //     return $this->hasMany(Printer::class);
    // }
}
