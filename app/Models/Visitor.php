<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = ['email', 'nama', 'satuan_kerja'];

    public function logs()
    {
        return $this->hasMany(VisitorLog::class);
    }
}
