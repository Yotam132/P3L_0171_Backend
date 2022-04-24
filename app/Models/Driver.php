<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Driver extends Model
{
    use HasFactory;

    public $primaryKey  = 'idDriver';

    protected $fillable = [
        'idDriverGenerated',
        'namaDrv',
        'alamatDrv',
        'tglLahirDrv',
        'jenisKelaminDrv',
        'emailDrv',
        'noTelpDrv',
        'bahasaAsing',
        'urlFotoDrv',
        'statusDrv',
        'simDrv',
        'tarifDrv',
        'suratBebasNapzaDrv',
        'suratKesehatanJiwaDrv',
        'suratKesehatanJasmaniDrv',
        'skckDrv',
        'rerataRatingDrv',
        'passwordDrv',
        'statusDokumenDrv',
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
