<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bws_reports', function (Blueprint $table) {
            $table->string('jenis_laporan')->nullable()->after('nomor_hp');
        });
    }

    public function down(): void
    {
        Schema::table('bws_reports', function (Blueprint $table) {
            $table->dropColumn('jenis_laporan');
        });
    }
};
