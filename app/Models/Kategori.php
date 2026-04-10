<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = ['nama_kategori', 'nominal_default', 'satuan', 'is_deduction'];

    protected $casts = ['is_deduction' => 'boolean'];
}
