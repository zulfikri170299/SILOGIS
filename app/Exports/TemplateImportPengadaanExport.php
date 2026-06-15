<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromArray;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TemplateImportPengadaanExport implements WithHeadings, ShouldAutoSize, WithStyles, FromArray
{
    public function headings(): array
    {
        return [
            'SATKER',
            'PELAKU PENGADAAN',
            'NAMA',
            'PANGKAT',
            'NRP/NIP',
            'NOMOR KEP/SPRIN',
            'TANGGAL KEP/SPRIN',
            'MENANGANI PAKET',
            'NILAI PAGU',
            'NILAI KONTRAK',
            'METODE PENGADAAN',
            'NAMA PENYEDIA',
            'NOMOR KONTRAK',
            'TANGGAL MULAI KONTRAK',
            'TANGGAL SELESAI KONTRAK',
            'KETERANGAN',
        ];
    }

    public function array(): array
    {
        return [
            [
                'BIRO LOGISTIK', // SATKER
                'PEJABAT PEMBUAT KOMITMEN', // PELAKU PENGADAAN
                'BUDI SANTOSO', // NAMA
                'AKBP', // PANGKAT
                '78020123', // NRP/NIP
                'KEP/123/I/2026', // NOMOR KEP/SPRIN
                '2026-01-10', // TANGGAL KEP/SPRIN
                'PENGADAAN KENDARAAN DINAS', // MENANGANI PAKET
                '150000000', // NILAI PAGU
                '145000000', // NILAI KONTRAK
                'TENDER', // METODE PENGADAAN
                'PT. MAJU MUNDUR', // NAMA PENYEDIA
                'KONTRAK/456/II/2026', // NOMOR KONTRAK
                '2026-02-01', // TANGGAL MULAI KONTRAK
                '2026-12-31', // TANGGAL SELESAI KONTRAK
                'CONTOH PENGISIAN (BARIS INI BISA DIHAPUS/DITIMPA)', // KETERANGAN
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF0F172A'],
                ],
            ],
            // Memberikan gaya miring dan warna abu-abu untuk baris contoh agar lebih jelas
            2 => [
                'font' => ['italic' => true, 'color' => ['argb' => 'FF666666']],
            ]
        ];
    }
}
