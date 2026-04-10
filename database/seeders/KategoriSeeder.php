<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        // insertOrIgnore: skip jika nama_kategori sudah ada
        DB::table('kategoris')->insertOrIgnore([
            ['nama_kategori' => 'Cuti',             'nominal_default' => 100000, 'satuan' => 'hari',       'is_deduction' => true,  'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Kehadiran',        'nominal_default' => 150000, 'satuan' => 'hari',       'is_deduction' => false, 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Lembur',           'nominal_default' => 50000,  'satuan' => 'jam',        'is_deduction' => false, 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Perjalanan Dinas', 'nominal_default' => 300000, 'satuan' => 'perjalanan', 'is_deduction' => false, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
