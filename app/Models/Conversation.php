<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Conversation extends Model
{
    use HasFactory;

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function lastMessage(): HasOne
    {
        return $this->hasOne(Message::class)->latest();
    }

    /**
     * Common for all
     *
     * @param Builder $query
     * @param User|null $user
     * @param int $limit
     * @return Builder
     */
    function scopeFilterAndLimit(Builder $query, ?User $user = null, int $limit): Builder
    {
        return $query
            ->when($user, fn(Builder $query) => $query->whereHas('participants', static fn (Builder $query) => $query->whereBelongsTo($user)))
            ->limit($limit)
            ->with('lastMessage.user');
    }
}
