<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SatkerInput extends Model
{
    protected $fillable = ['satker_id', 'bagian_id', 'judul', 'deskripsi', 'file_lampiran'];

    public function satker()
    {
        return $this->belongsTo(Satker::class);
    }

    public function bagian()
    {
        return $this->belongsTo(Bagian::class);
    }
}
