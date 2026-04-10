<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model
{
    protected $fillable = [
        'karyawan_id',
        'jml_hadir',   'nominal_hadir',
        'jml_lembur',  'nominal_lembur',
        'jml_dinas',   'nominal_dinas',
        'jml_cuti',    'nominal_cuti',
        'total_hadir', 'total_lembur',
        'total_dinas', 'total_cuti',
        'grand_total', 'periode',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
