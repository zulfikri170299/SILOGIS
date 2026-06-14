<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Satker extends Model
{
    protected $fillable = ['name', 'urutan'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function inputs()
    {
        return $this->hasMany(SatkerInput::class);
    }
}
