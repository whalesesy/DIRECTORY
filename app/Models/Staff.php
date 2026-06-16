<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staff';

    protected $fillable = [
        'department_id',
        'name',
        'role',
        'ext',
        'email',
        'office_message',
        'is_senior',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_senior' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    protected static function booted()
    {
        static::saved(function () {
            cache()->forget('api.departments');
        });
        static::deleted(function () {
            cache()->forget('api.departments');
        });
    }
}
