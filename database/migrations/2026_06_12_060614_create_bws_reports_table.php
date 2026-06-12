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
        Schema::create('bws_reports', function (Blueprint $table) {
            $table->id();
            $table->string('bagian');
            $table->string('nama');
            $table->string('nomor_hp');
            $table->text('aduan');
            $table->string('bukti_dukung')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bws_reports');
    }
};
