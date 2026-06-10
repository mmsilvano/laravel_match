<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ConversationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use LogicException;

class Conversation extends Model
{
    /** @use HasFactory<ConversationFactory> */
    use HasFactory;

    use SoftDeletes;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'user_one_id',
        'user_two_id',
    ];

    public function userOne(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_one_id');
    }

    public function userTwo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_two_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->orderBy('created_at');
    }

    public function latestMessage(): HasOne
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    public function otherParticipant(User $user): User
    {
        return match ($user->getKey()) {
            $this->user_one_id => $this->userTwo,
            $this->user_two_id => $this->userOne,
            default => throw new LogicException('User does not belong to this conversation.'),
        };
    }

    public function unreadCountFor(User $user): int
    {
        return $this->messages()
            ->whereNull('read_at')
            ->where('sender_id', '!=', $user->getKey())
            ->count();
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'user_one_id' => 'integer',
            'user_two_id' => 'integer',
            'deleted_at' => 'datetime',
        ];
    }
}
