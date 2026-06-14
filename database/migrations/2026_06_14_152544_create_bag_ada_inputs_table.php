<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bag_ada_inputs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('satker_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('pelaku_pengadaan_id')->constrained('master_pelaku_pengadaans');
            $table->string('nama');
            $table->string('pangkat')->nullable();
            $table->string('nrp_nip')->nullable();
            $table->string('kep_nomor')->nullable();
            $table->date('kep_tanggal')->nullable();
            $table->string('menangani_paket')->nullable();
            $table->bigInteger('nilai_pagu')->nullable();
            $table->bigInteger('nilai_kontrak')->nullable();
            $table->foreignId('metode_pengadaan_id')->constrained('master_metode_pengadaans');
            $table->string('nama_penyedia')->nullable();
            $table->string('kontrak_nomor')->nullable();
            $table->date('kontrak_tanggal_mulai')->nullable();
            $table->date('kontrak_tanggal_selesai')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bag_ada_inputs');
    }
};
