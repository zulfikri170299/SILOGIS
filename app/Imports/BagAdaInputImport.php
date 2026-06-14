<?php

namespace App\Imports;

use App\Models\BagAdaInput;
use App\Models\Satker;
use App\Models\MasterPelakuPengadaan;
use App\Models\MasterMetodePengadaan;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class BagAdaInputImport implements ToModel, WithHeadingRow
{
    protected $satkers;
    protected $pelakus;
    protected $metodes;

    public function __construct()
    {
        // Cache master data to avoid querying for each row
        $this->satkers = Satker::all()->keyBy(function($item) {
            return strtolower(trim($item->name));
        });
        
        $this->pelakus = MasterPelakuPengadaan::all()->keyBy(function($item) {
            return strtolower(trim($item->nama_peran));
        });
        
        $this->metodes = MasterMetodePengadaan::all()->keyBy(function($item) {
            return strtolower(trim($item->nama_metode));
        });
    }

    public function model(array $row)
    {
        $satkerName = strtolower(trim($row['satker'] ?? ''));
        $satkerId = isset($this->satkers[$satkerName]) ? $this->satkers[$satkerName]->id : null;

        // Skip if satker is not valid (must have a valid satker)
        if (!$satkerId) {
            return null;
        }

        $pelakuName = strtolower(trim($row['pelaku_pengadaan'] ?? ''));
        $pelakuId = isset($this->pelakus[$pelakuName]) ? $this->pelakus[$pelakuName]->id : null;

        $metodeName = strtolower(trim($row['metode_pengadaan'] ?? ''));
        $metodeId = isset($this->metodes[$metodeName]) ? $this->metodes[$metodeName]->id : null;

        // Format dates correctly from Excel
        $kepTanggal = isset($row['tanggal_kepsprin']) ? $this->transformDate($row['tanggal_kepsprin']) : null;
        $kontrakTanggalMulai = isset($row['tanggal_mulai_kontrak']) ? $this->transformDate($row['tanggal_mulai_kontrak']) : null;
        $kontrakTanggalSelesai = isset($row['tanggal_selesai_kontrak']) ? $this->transformDate($row['tanggal_selesai_kontrak']) : null;

        return new BagAdaInput([
            'satker_id' => $satkerId,
            'user_id' => Auth::id(),
            'pelaku_pengadaan_id' => $pelakuId,
            'nama' => $row['nama'] ?? null,
            'pangkat' => $row['pangkat'] ?? null,
            'nrp_nip' => $row['nrpnip'] ?? null,
            'kep_nomor' => $row['nomor_kepsprin'] ?? null,
            'kep_tanggal' => $kepTanggal,
            'menangani_paket' => $row['menangani_paket'] ?? null,
            'nilai_pagu' => $row['nilai_pagu'] ?? null,
            'nilai_kontrak' => $row['nilai_kontrak'] ?? null,
            'metode_pengadaan_id' => $metodeId,
            'nama_penyedia' => $row['nama_penyedia'] ?? null,
            'kontrak_nomor' => $row['nomor_kontrak'] ?? null,
            'kontrak_tanggal_mulai' => $kontrakTanggalMulai,
            'kontrak_tanggal_selesai' => $kontrakTanggalSelesai,
            'keterangan' => $row['keterangan'] ?? null,
        ]);
    }

    private function transformDate($value, $format = 'Y-m-d')
    {
        try {
            if (is_numeric($value)) {
                return Date::excelToDateTimeObject($value)->format($format);
            }
            return date($format, strtotime($value));
        } catch (\Exception $e) {
            return null;
        }
    }
}
