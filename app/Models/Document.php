<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'original_filename',
        'file_path',
        'file_type',
        'file_size',
        'description',
        'category',
        'document_folder_id'
    ];

    public function folder()
    {
        return $this->belongsTo(DocumentFolder::class, 'document_folder_id');
    }
}
