<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Mobil extends Model
{
    use HasFactory;

    public $primaryKey  = 'idMobil';

    protected $fillable = [
        'idMitra',
        'namaMbl',
        'urlFotoMbl',
        'tipeMbl',
        'jenisTransmisi',
        'jenisBahanBakar',
        'warna',
        'volumeBahanBakar',
        'kapasitasPenumpang',
        'fasilitas',
        'platNomor',
        'noStnk',
        'hargaSewa',
        'kategoriAset',
        'periodeKontrakMulai',
        'periodeKontrakAkhir',
        'tglServisTerakhir',
        'statusMbl',
    ];

    public function getCreatedAtAttribute()
    {
        if(!is_null($this->attributes['created_at']))
        {
            return Carbon::parse($this->attributes['created_at'])->format('Y-m-d H:i:s');
        }
    }

    public function getUpdatedAtAttribute()
    {
        if(!is_null($this->attributes['updated_at']))
        {
            return Carbon::parse($this->attributes['updated_at'])->format('Y-m-d H:i:s');
        }
    }
}
