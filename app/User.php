<?php

namespace App;

use App\Models\Reply;
use App\Models\Thread;
use App\Helpers\ModelHelpers;
use App\Helpers\HasTimestamps;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasTimestamps, ModelHelpers, Notifiable;

    const DEFAULT = 1;
    const MODERATOR = 2;
    const ADMIN = 3;

    /**
     * {@inheritdoc}
     */
    protected $table = 'users';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'ip',
        'confirmed',
        'confirmation_code',
        'github_id',
        'github_url',
        'type',
        'remember_token',
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = ['password', 'remember_token'];

    public function id(): int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function emailAddress(): string
    {
        return $this->email;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function githubUsername(): string
    {
        return $this->github_url;
    }

    public function gratavarUrl($size = 100): string
    {
        $hash = md5(strtolower(trim($this->email)));

        return "https://www.gravatar.com/avatar/$hash?s=$size";
    }

    public function isConfirmed(): bool
    {
        return (bool) $this->confirmed;
    }

    public function isUnconfirmed(): bool
    {
        return ! $this->isConfirmed();
    }

    public function confirm()
    {
        $this->update(['confirmed' => true, 'confirmation_code' => null]);
    }

    public function confirmationCode(): string
    {
        return (string) $this->confirmation_code;
    }

    public function matchesConfirmationCode(string $code): bool
    {
        return $this->confirmation_code === $code;
    }

    public function ban()
    {
        $this->is_banned = true;

        $this->save();
    }

    public function unban()
    {
        $this->is_banned = false;

        $this->save();
    }

    public function isBanned(): bool
    {
        return (bool) $this->is_banned;
    }

    public function type(): int
    {
        return (int) $this->type;
    }

    public function isModerator(): bool
    {
        return $this->type() === self::MODERATOR;
    }

    public function isAdmin(): bool
    {
        return $this->type() === self::ADMIN;
    }

    /**
     * @return \App\Models\Thread[]
     */
    public function threads()
    {
        return $this->threadsRelation;
    }

    /**
     * @return \App\Models\Thread[]
     */
    public function latestThreads(int $amount = 3)
    {
        return $this->threadsRelation->take($amount);
    }

    public function deleteThreads()
    {
        // We need to explicitly iterate over the threads and delete them
        // separately because all related models need to be deleted.
        foreach ($this->threads() as $thread) {
            $thread->delete();
        }
    }

    public function threadsRelation(): HasMany
    {
        return $this->hasMany(Thread::class, 'author_id');
    }

    public function countThreads(): int
    {
        return $this->threadsRelation()->count();
    }

    /**
     * @return \App\Models\Reply[]
     */
    public function replies()
    {
        return $this->replyAble;
    }

    /**
     * @return \App\Models\Reply[]
     */
    public function latestReplies(int $amount = 3)
    {
        return $this->replyAble()->latest()->limit($amount)->get();
    }

    public function deleteReplies()
    {
        $this->replyAble()->delete();
    }

    public function countReplies(): int
    {
        return $this->replyAble()->count();
    }

    public function replyAble(): HasMany
    {
        return $this->hasMany(Reply::class, 'author_id');
    }

    /**
     * @todo Make this work with Eloquent instead of a collection
     */
    public function countSolutions(): int
    {
        return $this->replies()->filter(function (Reply $reply) {
            if ($reply->replyAble() instanceof Thread) {
                return $reply->replyAble()->isSolutionReply($reply);
            }

            return false;
        })->count();
    }

    public static function findByUsername(string $username): User
    {
        return static::where('username', $username)->firstOrFail();
    }

    public static function findByEmailAddress(string $emailAddress): User
    {
        return static::where('email', $emailAddress)->firstOrFail();
    }

    public static function findByGithubId(string $githubId): User
    {
        return static::where('github_id', $githubId)->firstOrFail();
    }

    public function delete()
    {
        $this->deleteThreads();
        $this->deleteReplies();

        parent::delete();
    }
}
