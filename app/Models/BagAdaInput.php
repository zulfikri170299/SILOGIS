<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BagAdaInput extends Model
{
    protected $fillable = [
        'satker_id',
        'user_id',
        'pelaku_pengadaan_id',
        'nama',
        'pangkat',
        'nrp_nip',
        'kep_nomor',
        'kep_tanggal',
        'menangani_paket',
        'nilai_pagu',
        'nilai_kontrak',
        'metode_pengadaan_id',
        'nama_penyedia',
        'kontrak_nomor',
        'kontrak_tanggal_mulai',
        'kontrak_tanggal_selesai',
        'keterangan'
    ];

    protected $casts = [
        'kep_tanggal' => 'date',
        'kontrak_tanggal_mulai' => 'date',
        'kontrak_tanggal_selesai' => 'date',
    ];

    public function satker()
    {
        return $this->belongsTo(Satker::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pelakuPengadaan()
    {
        return $this->belongsTo(MasterPelakuPengadaan::class, 'pelaku_pengadaan_id');
    }

    public function metodePengadaan()
    {
        return $this->belongsTo(MasterMetodePengadaan::class, 'metode_pengadaan_id');
    }

    // Accessors & Mutators for Uppercase formatting
    protected function nama(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: fn ($value) => $value ? strtoupper($value) : $value,
            set: fn ($value) => $value ? strtoupper($value) : $value,
        );
    }

    protected function pangkat(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: fn ($value) => $value ? strtoupper($value) : $value,
            set: fn ($value) => $value ? strtoupper($value) : $value,
        );
    }

    protected function nrpNip(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: fn ($value) => $value ? strtoupper($value) : $value,
            set: fn ($value) => $value ? strtoupper($value) : $value,
        );
    }

    protected function kepNomor(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: fn ($value) => $value ? strtoupper($value) : $value,
            set: fn ($value) => $value ? strtoupper($value) : $value,
        );
    }

    protected function menanganiPaket(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: fn ($value) => $value ? strtoupper($value) : $value,
            set: fn ($value) => $value ? strtoupper($value) : $value,
        );
    }

    protected function namaPenyedia(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: fn ($value) => $value ? strtoupper($value) : $value,
            set: fn ($value) => $value ? strtoupper($value) : $value,
        );
    }

    protected function kontrakNomor(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: fn ($value) => $value ? strtoupper($value) : $value,
            set: fn ($value) => $value ? strtoupper($value) : $value,
        );
    }

    protected function keterangan(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: fn ($value) => $value ? strtoupper($value) : $value,
            set: fn ($value) => $value ? strtoupper($value) : $value,
        );
    }
}
