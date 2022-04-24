<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pegawai extends Model
{
use HasFactory;

public $primaryKey  = 'idPegawai';

    protected $fillable = [
        'namaPgw',
        'alamatPgw',
        'tglLahirPgw',
        'jenisKelaminPgw',
        'emailPgw',
        'noTelpPgw',
        'urlFotoPgw',
        'jumlahShiftPgw',
        'idRole',
        'passwordPgw',
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
