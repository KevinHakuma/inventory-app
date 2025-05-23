<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaptopModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'laptops';

    protected $fillable = [
        'jenis',
        'nama_aset',
        'kode_aset',
        'kategori_id',
        'cabang_id',
        'user',
        'merek',
        'processor',
        'ram',
        'storage',
        'kondisi',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriModel::class, 'kategori_id');
    }

    public function cabang()
    {
        return $this->belongsTo(CabangModel::class);
    }

    public function perpindahanHistory()
    {
        return $this->hasMany(\App\Models\PerpindahanAsetModel::class, 'asset_id')->where('kategori_id', $this->kategori_id);
    }
}
