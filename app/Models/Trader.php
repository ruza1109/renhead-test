<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trader extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'working_hours',
        'payroll_per_hour',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static function booted(): void
    {
        static::deleting(function ($trader) {
            $trader->user()->delete();

            $trader->jobs()->each(function ($job) {
                $job->delete();
            });
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jobs(): MorphMany
    {
        return $this->morphMany(Job::class, 'employee');
    }
}
