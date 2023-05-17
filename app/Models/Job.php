<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'employee_type',
        'date',
        'total_hours',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function booted(): void
    {
        static::deleting(function ($job) {
            $job->approval()->delete();
        });
    }

    public function approval(): BelongsTo
    {
        return $this->belongsTo(Approval::class, 'id', 'job_id');
    }

    public function employee(): MorphTo
    {
        return $this->morphTo();
    }
}
