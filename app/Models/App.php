<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    protected $fillable = [
        'title',
        'url',
        'icon',
        'category',
        'description',
    ];
}
