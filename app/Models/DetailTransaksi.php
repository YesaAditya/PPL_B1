<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    public function Transaksi(){
        return $this->belongsTo(Transaksi::class);
    }

    public function Katalog(){
        return $this->belongsTo(Katalog::class);
    }
}
