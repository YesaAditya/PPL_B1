<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusTransaksi extends Model
{
    public function Transaksi(){
        return $this->hasMany(Transaksi::class);
    }
}
