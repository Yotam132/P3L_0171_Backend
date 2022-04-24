<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Customer extends Model
{
    use HasFactory;

    public $primaryKey  = 'idCustomer';

    protected $fillable = [
        'idCustomerGenerated',
        'namaCust',
        'alamatCust',
        'tglLahirCust',
        'jenisKelaminCust',
        'emailCust',
        'noTelpCust',
        'kartuPengenalCust',
        'simCust',
        'passwordCust',
        'statusDokumenCust'
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
