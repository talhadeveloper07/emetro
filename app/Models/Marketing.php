<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;  

class Marketing extends Model
{
    use HasFactory;

    protected $table = 'marketing';

    protected $fillable = [
        'title',
        'description',
        'document',
        'category',
        'image',
        'content_type',
    ];

    // 🔎 Scopes for quick filtering
    public function scopeLogos($query)
    {
        return $query->where('type', 'logo');
    }

    public function scopeBrochures($query)
    {
        return $query->where('type', 'brochure');
    }

    public function scopeImages($query)
    {
        return $query->where('type', 'image');
    }

    public function scopeVideos($query)
    {
        return $query->where('type', 'video');
    }

    public function scopePresentations($query)
    {
        return $query->where('type', 'presentation');
    }
}