<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'name',
        'title',
        'quote',
        'vision',
        'mission',
        'years_of_service',
        'integrity_service',
        'photo',
        'ecosystem_description'
    ];
}
