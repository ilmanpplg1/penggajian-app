<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus duplikat dulu — simpan hanya id terkecil per nama_kategori
        $duplikats = DB::table('kategoris')
            ->select('nama_kategori', DB::raw('MIN(id) as keep_id'))
            ->groupBy('nama_kategori')
            ->get();

        foreach ($duplikats as $row) {
            DB::table('kategoris')
                ->where('nama_kategori', $row->nama_kategori)
                ->where('id', '!=', $row->keep_id)
                ->delete();
        }

        // Tambah unique constraint
        Schema::table('kategoris', function (Blueprint $table) {
            $table->unique('nama_kategori');
        });
    }

    public function down(): void
    {
        Schema::table('kategoris', function (Blueprint $table) {
            $table->dropUnique(['nama_kategori']);
        });
    }
};
