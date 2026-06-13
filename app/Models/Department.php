<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'short_name',
        'icon',
        'accent_color',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function staff(): HasMany
    {
        return $this->hasMany(Staff::class)->where('is_senior', false)->where('is_active', true)->orderBy('sort_order')->orderBy('name');
    }

    public function allStaff(): HasMany
    {
        return $this->hasMany(Staff::class)->orderBy('is_senior', 'desc')->orderBy('sort_order')->orderBy('name');
    }

    public function senior(): HasOne
    {
        return $this->hasOne(Staff::class)->where('is_senior', true)->where('is_active', true);
    }
}
