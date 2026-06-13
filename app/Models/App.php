<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    protected $fillable = [
        'title',
        'urutan',
        'url',
        'icon',
        'category',
        'description',
    ];
}
