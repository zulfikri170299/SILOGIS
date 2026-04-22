<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Profile::updateOrCreate(['id' => 1], [
            'name' => 'KOMBES POL. PUJI PRAYITNO, S.I.K., M.H.',
            'title' => 'KAROLOG POLDA NTB',
            'photo' => 'pimpinan.png',
            'quote' => 'Logistik bukan hanya tentang pengadaan, tapi tentang memastikan setiap personel memiliki dukungan terbaik untuk menjaga keamanan masyarakat NTB. Kami berkomitmen pada transparansi dan modernisasi layanan di era digital ini.',
            'vision' => 'Menjadi Biro Logistik yang unggul, profesional, dan akuntabel dalam memberikan dukungan logistik yang cepat dan tepat sasaran.',
            'mission' => "• Modernisasi pengelolaan aset negara.\n• Transparansi pengadaan barang/jasa.\n• Peningkatan profesionalisme personel.",
            'years_of_service' => '30+',
            'integrity_service' => '100%',
        ]);
    }
}
