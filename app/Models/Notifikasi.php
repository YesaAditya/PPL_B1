<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $fillable = ['transaksi_id', 'pesan', 'dibaca'];

    public function Transaksi(){
        return $this->belongsTo(Transaksi::class);
    }
}
