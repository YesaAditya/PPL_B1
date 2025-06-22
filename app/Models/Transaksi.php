<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Transaksi extends Model
{

    public function DetailTransaksi(){
        return $this->hasMany(DetailTransaksi::class);
    }

    public function MetodePengiriman(){
        return $this->belongsTo(MetodePengirimans::class);
    }

    public function StatusTransaksi(){
        return $this->belongsTo(StatusTransaksi::class);
    }

    public function Notifikasi(){
        return $this->hasMany(Notifikasi::class);
    }

    public function Profil(){
        return $this->belongsTo(Profil::class);
    }


}
