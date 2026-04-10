<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penggajians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('karyawans')->onDelete('cascade');
            $table->integer('jml_hadir')->default(0);
            $table->bigInteger('nominal_hadir')->default(0);
            $table->integer('jml_lembur')->default(0);
            $table->bigInteger('nominal_lembur')->default(0);
            $table->integer('jml_dinas')->default(0);
            $table->bigInteger('nominal_dinas')->default(0);
            $table->integer('jml_cuti')->default(0);
            $table->bigInteger('nominal_cuti')->default(0);
            $table->bigInteger('total_hadir')->default(0);
            $table->bigInteger('total_lembur')->default(0);
            $table->bigInteger('total_dinas')->default(0);
            $table->bigInteger('total_cuti')->default(0);
            $table->bigInteger('grand_total')->default(0);
            $table->date('periode');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penggajians');
    }
};
