<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganogramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Organogram::truncate();

        // Level 1: Root
        $karolog = \App\Models\Organogram::create(['position' => 'KAROLOG POLDA NTB', 'name' => 'SAPTO PRIYONO', 'rank' => 'KOMBES POL', 'order' => 1]);

        // Renmin branch
        $renmin = $karolog->children()->create(['position' => 'KASUBBAG RENMIN', 'name' => '-', 'rank' => '-', 'order' => 1]);
        $renmin->children()->create(['position' => 'KAUR REN', 'name' => '-', 'rank' => '-', 'order' => 1]);
        $renmin->children()->create(['position' => 'KAUR MINTU', 'name' => '-', 'rank' => '-', 'order' => 2]);
        $renmin->children()->create(['position' => 'KAUR KEU', 'name' => '-', 'rank' => '-', 'order' => 3]);

        // 5 Kabags
        $ada = $karolog->children()->create(['position' => 'KABAG ADA', 'name' => '-', 'rank' => '-', 'order' => 2]);
        $infolog = $karolog->children()->create(['position' => 'KABAG INFOLOG', 'name' => '-', 'rank' => '-', 'order' => 3]);
        $bekum = $karolog->children()->create(['position' => 'KABAG BEKUM', 'name' => 'PRATIWI NOFIANI', 'rank' => 'KOMPOL', 'order' => 4]);
        $pal = $karolog->children()->create(['position' => 'KABAG PAL', 'name' => '-', 'rank' => '-', 'order' => 5]);
        $faskon = $karolog->children()->create(['position' => 'KABAG FASKON', 'name' => '-', 'rank' => '-', 'order' => 6]);

        // Ada Children
        $ada->children()->create(['position' => 'KSB LP', 'name' => '-', 'rank' => '-', 'order' => 1]);
        $ada->children()->create(['position' => 'KSB LPSE', 'name' => '-', 'rank' => '-', 'order' => 2]);

        // Infolog Children
        $infolog->children()->create(['position' => 'KSB PBMN', 'name' => '-', 'rank' => '-', 'order' => 1]);
        $infolog->children()->create(['position' => 'KSB KESJAS', 'name' => '-', 'rank' => '-', 'order' => 2]);

        // Bekum Children
        $bekum->children()->create(['position' => 'KSB BBMP', 'name' => '-', 'rank' => '-', 'order' => 1]);
        $bekum->children()->create(['position' => 'KSB KAPSINTOR', 'name' => '-', 'rank' => '-', 'order' => 2]);

        // Pal Children
        $pal->children()->create(['position' => 'KSB ALSUSANG', 'name' => '-', 'rank' => '-', 'order' => 1]);
        $pal->children()->create(['position' => 'KSB SENMU', 'name' => '-', 'rank' => '-', 'order' => 2]);

        // Faskon Children
        $faskon->children()->create(['position' => 'KSB KONBANGTA', 'name' => '-', 'rank' => '-', 'order' => 1]);
        $faskon->children()->create(['position' => 'KSB PRASENTAL', 'name' => '-', 'rank' => '-', 'order' => 2]);

        // Kaur Gudang (Bottom directly from main trunk / under karolog)
        $karolog->children()->create(['position' => 'KAUR GUDANG', 'name' => '-', 'rank' => '-', 'order' => 7]);
    }
}
