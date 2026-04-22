<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organogram extends Model
{
    protected $fillable = [
        'name',
        'rank',
        'position',
        'photo',
        'parent_id',
        'order',
    ];

    public function children()
    {
        return $this->hasMany(Organogram::class, 'parent_id')->orderBy('order', 'asc');
    }

    public function parent()
    {
        return $this->belongsTo(Organogram::class, 'parent_id');
    }
}
