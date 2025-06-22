<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Katalog extends Model
{
    protected $table = 'katalog';

    protected $fillable = [
        'nama_produk', 'deskripsi', 'harga', 'stok', 'satuan','foto'
    ];

    public function DetailTransaksi(){
        return $this->hasMany(DetailTransaksi::class);
    }
}
