<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PasswordResetChallenge extends Model
{
    protected $table = 'password_reset_challenges';

    protected $fillable = [
        'admin_user_id',
        'otp_hash',
        'expires_at',
        'attempt_count',
        'max_attempts',
        'used_at',
        'last_sent_at',
        'request_ip',
        'reset_token_hash',
        'reset_token_expires_at',
        'reset_token_used_at',
    ];

    protected $hidden = [
        'otp_hash',
        'reset_token_hash',
    ];

    protected $casts = [
        'expires_at'             => 'datetime',
        'used_at'                => 'datetime',
        'last_sent_at'           => 'datetime',
        'reset_token_expires_at' => 'datetime',
        'reset_token_used_at'    => 'datetime',
        'attempt_count'          => 'integer',
        'max_attempts'           => 'integer',
    ];

    public function adminUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_user_id');
    }

    public function isExpired(): bool
    {
        return $this->expires_at ? $this->expires_at->isPast() : true;
    }

    public function isUsed(): bool
    {
        return !is_null($this->used_at);
    }

    public function hasExceededAttempts(): bool
    {
        return $this->attempt_count >= $this->max_attempts;
    }

    public function isResetTokenValid(string $plainToken): bool
    {
        if (
            empty($this->reset_token_hash) ||
            !is_null($this->reset_token_used_at) ||
            !$this->reset_token_expires_at ||
            $this->reset_token_expires_at->isPast()
        ) {
            return false;
        }

        return hash_equals($this->reset_token_hash, hash('sha256', $plainToken));
    }
}
