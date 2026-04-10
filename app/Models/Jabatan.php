<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $fillable = ['nama_jabatan', 'departemen_id'];

    public function departemen()
    {
        return $this->belongsTo(Departemen::class);
    }

    public function karyawans()
    {
        return $this->hasMany(Karyawan::class);
    }
}
