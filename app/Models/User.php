<?php

namespace App\Models;

use App\Enums\UserType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'type',
        'password',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    public static function booted(): void
    {
        static::deleting(function ($user) {
            $user->traders()->each(function ($trader) {
                $trader->delete();
            });

            $user->professors()->each(function ($professor) {
                $professor->delete();
            });

            $user->approvals()->where('user_id', $user->id)->delete();
        });
    }

    public function traders(): HasMany
    {
        return $this->hasMany(Trader::class);
    }

    public function professors(): HasMany
    {
        return $this->hasMany(Professor::class);
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(Approval::class);
    }

    public function isApprover(): bool
    {
        return $this->type === UserType::APPROVER->value;
    }
}
