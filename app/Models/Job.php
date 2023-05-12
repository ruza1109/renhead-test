<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'employee_type',
        'date',
        'total_hours',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function approval(): BelongsTo
    {
        return $this->belongsTo(Approval::class);
    }

    public function employee(): MorphTo
    {
        return $this->morphTo();
    }
}
