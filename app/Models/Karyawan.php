<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $fillable = ['nama', 'nip', 'email', 'no_hp', 'alamat', 'jabatan_id', 'tanggal_masuk'];

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }
}
