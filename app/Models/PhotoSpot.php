<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhotoSpot extends Model
{
    protected $table = 'photo_spots';

    protected $fillable = [
        'site_scope',
        'name',
        'best_time_tag',
        'description',
        'image_url',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
