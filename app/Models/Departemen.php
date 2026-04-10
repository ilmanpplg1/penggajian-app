<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    protected $fillable = ['kode_departemen', 'nama_departemen', 'deskripsi'];

    public function jabatans()
    {
        return $this->hasMany(Jabatan::class);
    }
}
