<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Transaksi extends Model
{
    use HasFactory;

    public $primaryKey  = 'idTransaksi';

    protected $fillable = [
        'idMobil',
        'idDriver',
        'idCustomer',
        'tglSewaAwal',
        'tglSewaAkhir',
        'metodePembayaran',
        'subTotal',
        'idPegawai',
        'idPromo',
        'idTransaksiGenerated',
        'tglPengembalian',
        'statusTransaksi',
        'totalHargaAkhir',
        'ratingDriver',
        'ratingPerusahaan',
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

    public function getID($idc)
    {
        return sprintf('%03d', $idc + 1);
    }
}
