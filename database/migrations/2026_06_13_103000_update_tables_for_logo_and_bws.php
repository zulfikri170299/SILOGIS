<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('logo')->nullable();
        });

        Schema::table('bws_reports', function (Blueprint $table) {
            $table->string('nama')->nullable()->change();
            $table->string('nomor_hp')->nullable()->change();
            $table->string('bukti_dukung_tambahan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropColumn('logo');
        });

        Schema::table('bws_reports', function (Blueprint $table) {
            $table->string('nama')->nullable(false)->change();
            $table->string('nomor_hp')->nullable(false)->change();
            $table->dropColumn('bukti_dukung_tambahan');
        });
    }
};
