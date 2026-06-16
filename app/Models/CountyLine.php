<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountyLine extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'number',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted()
    {
        static::saved(function () {
            cache()->forget('api.county_lines');
        });
        static::deleted(function () {
            cache()->forget('api.county_lines');
        });
    }
}
