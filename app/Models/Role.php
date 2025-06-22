<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_role'
    ];

    /**
     * Hubungan dengan model User
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
