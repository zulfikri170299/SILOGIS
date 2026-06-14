<?php

namespace App\Exports;

use App\Models\MasterMetodePengadaan;
use App\Models\MasterPelakuPengadaan;
use App\Models\Satker;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TemplateImportPengadaanExport implements WithHeadings, WithEvents, ShouldAutoSize, WithStyles
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
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                $satkers = Satker::orderBy('name')->pluck('name')->toArray();
                $pelakus = MasterPelakuPengadaan::orderBy('nama_peran')->pluck('nama_peran')->toArray();
                $metodes = MasterMetodePengadaan::orderBy('nama_metode')->pluck('nama_metode')->toArray();
                
                $spreadsheet = $sheet->getParent();
                $dataSheet = $spreadsheet->createSheet();
                $dataSheet->setTitle('Data Referensi');
                
                foreach ($satkers as $index => $satker) {
                    $dataSheet->setCellValue('A' . ($index + 1), $satker);
                }
                foreach ($pelakus as $index => $pelaku) {
                    $dataSheet->setCellValue('B' . ($index + 1), $pelaku);
                }
                foreach ($metodes as $index => $metode) {
                    $dataSheet->setCellValue('C' . ($index + 1), $metode);
                }
                
                $dataSheet->setSheetState(Worksheet::SHEETSTATE_HIDDEN);

                // Satker (Column A)
                $valA = new DataValidation();
                $valA->setType(DataValidation::TYPE_LIST);
                $valA->setErrorStyle(DataValidation::STYLE_STOP);
                $valA->setAllowBlank(true);
                $valA->setShowInputMessage(true);
                $valA->setShowErrorMessage(true);
                $valA->setShowDropDown(true);
                $valA->setErrorTitle('Pilihan Tidak Valid');
                $valA->setError('Pilih nilai dari dropdown list.');
                $valA->setFormula1('=\'Data Referensi\'!$A$1:$A$' . max(1, count($satkers)));
                $sheet->setDataValidation('A2:A1000', $valA);

                // Pelaku Pengadaan (Column B)
                $valB = new DataValidation();
                $valB->setType(DataValidation::TYPE_LIST);
                $valB->setErrorStyle(DataValidation::STYLE_STOP);
                $valB->setAllowBlank(true);
                $valB->setShowInputMessage(true);
                $valB->setShowErrorMessage(true);
                $valB->setShowDropDown(true);
                $valB->setErrorTitle('Pilihan Tidak Valid');
                $valB->setError('Pilih nilai dari dropdown list.');
                $valB->setFormula1('=\'Data Referensi\'!$B$1:$B$' . max(1, count($pelakus)));
                $sheet->setDataValidation('B2:B1000', $valB);

                // Metode Pengadaan (Column K)
                $valK = new DataValidation();
                $valK->setType(DataValidation::TYPE_LIST);
                $valK->setErrorStyle(DataValidation::STYLE_STOP);
                $valK->setAllowBlank(true);
                $valK->setShowInputMessage(true);
                $valK->setShowErrorMessage(true);
                $valK->setShowDropDown(true);
                $valK->setErrorTitle('Pilihan Tidak Valid');
                $valK->setError('Pilih nilai dari dropdown list.');
                $valK->setFormula1('=\'Data Referensi\'!$C$1:$C$' . max(1, count($metodes)));
                $sheet->setDataValidation('K2:K1000', $valK);
            },
        ];
    }
}
