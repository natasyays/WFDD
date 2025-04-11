<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{


    protected $fillable = ['nomor_lapangan', 'jam_mulai', 'jam_selesai'];

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class);
    }
}
