<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BagAdaInput;
use App\Models\Satker;
use App\Models\MasterPelakuPengadaan;
use App\Models\MasterMetodePengadaan;
use App\Models\User;
use Faker\Factory as Faker;

class BagAdaDummySeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $satkers = Satker::pluck('id')->toArray();
        $pelakus = MasterPelakuPengadaan::pluck('id')->toArray();
        $metodes = MasterMetodePengadaan::pluck('id')->toArray();
        $users = User::pluck('id')->toArray();

        if (empty($satkers) || empty($pelakus) || empty($metodes) || empty($users)) {
            $this->command->error('Pastikan tabel Satker, Pelaku, Metode, dan User sudah ada isinya minimal 1.');
            return;
        }

        for ($i = 0; $i < 25; $i++) {
            $nilaiPagu = $faker->numberBetween(50000000, 5000000000); // 50jt - 5M
            $nilaiKontrak = $nilaiPagu - $faker->numberBetween(1000000, 20000000); // Kontrak sedikit di bawah Pagu

            BagAdaInput::create([
                'satker_id' => $faker->randomElement($satkers),
                'user_id' => $faker->randomElement($users),
                'pelaku_pengadaan_id' => $faker->randomElement($pelakus),
                'nama' => $faker->name(),
                'pangkat' => $faker->randomElement(['PNS Gol III/a', 'PNS Gol III/b', 'PNS Gol IV/a', 'TNI AL Letda', 'Polri Iptu']),
                'nrp_nip' => $faker->numerify('19########## 1 0##'),
                'kep_nomor' => 'KEP/' . $faker->numberBetween(10, 999) . '/' . $faker->randomElement(['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII']) . '/' . date('Y'),
                'kep_tanggal' => $faker->dateTimeBetween('-1 year', 'now'),
                'menangani_paket' => 'Pengadaan ' . $faker->words(3, true),
                'nilai_pagu' => $nilaiPagu,
                'nilai_kontrak' => $nilaiKontrak,
                'metode_pengadaan_id' => $faker->randomElement($metodes),
                'nama_penyedia' => $faker->company(),
                'kontrak_nomor' => 'SPK/' . $faker->numberBetween(1, 100) . '/X/2026',
                'kontrak_tanggal_mulai' => $faker->dateTimeBetween('-6 months', 'now'),
                'kontrak_tanggal_selesai' => $faker->dateTimeBetween('now', '+6 months'),
                'keterangan' => $faker->randomElement(['Selesai', 'Proses Pengerjaan', 'Termin 1', 'Proses Tender', null]),
            ]);
        }
    }
}
