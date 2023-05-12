<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Professor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'total_available_hours',
        'payroll_per_hour',
        'total_projects',
        'office_number',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jobs(): MorphMany
    {
        return $this->morphMany(Job::class, 'employee');
    }
}
