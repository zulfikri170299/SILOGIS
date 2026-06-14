<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorLog extends Model
{
    protected $fillable = ['visitor_id', 'visited_at'];

    protected $casts = [
        'visited_at' => 'datetime',
    ];

    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }
}
