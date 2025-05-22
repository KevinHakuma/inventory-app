<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class PerpindahanAsetModel extends Model
{
    use HasFactory;

    protected $table = 'perpindahan_aset';

    protected $fillable = [
        'kategori_id',
        'asset_id',
        'cabang_asal_id',
        'cabang_tujuan_id',
        'user_baru',
        'keterangan',
        'tanggal_pindah',
    ];

    public function asset(): MorphTo
    {
        return $this->morphTo('asset');
    }

    public function cabangAsal()
    {
        return $this->belongsTo(CabangModel::class, 'cabang_asal_id');
    }

    public function cabangTujuan()
    {
        return $this->belongsTo(CabangModel::class, 'cabang_tujuan_id');
    }
}
