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
        'github_username',
        'type',
        'remember_token',
        'bio',
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

    public function bio(): string
    {
        return $this->bio;
    }

    public function githubUsername(): string
    {
        return $this->github_username;
    }

    public function gravatarUrl($size = 100): string
    {
        $hash = md5(strtolower(trim($this->email)));
        $default = urlencode(route('avatar', ['username' => $this->username()]));

        return "https://www.gravatar.com/avatar/$hash?s=$size&d=$default";
    }

    public function intercomHash(): string
    {
        return hash_hmac('sha256', $this->id(), config('services.intercom.secret'));
    }

    public function isConfirmed(): bool
    {
        return (bool) $this->confirmed;
    }

    public function isUnconfirmed(): bool
    {
        return ! $this->isConfirmed();
    }

    public function confirmationCode(): string
    {
        return (string) $this->confirmation_code;
    }

    public function matchesConfirmationCode(string $code): bool
    {
        return $this->confirmation_code === $code;
    }

    public function isBanned(): bool
    {
        return ! is_null($this->banned_at);
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

    public function hasPassword(): bool
    {
        $password = $this->getAuthPassword();

        return $password !== '' && $password !== null;
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
        return $this->threadsRelation()->latest()->limit($amount)->get();
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

    public static function findByUsername(string $username): self
    {
        return static::where('username', $username)->firstOrFail();
    }

    public static function findByEmailAddress(string $emailAddress): self
    {
        return static::where('email', $emailAddress)->firstOrFail();
    }

    public static function findByGithubId(string $githubId): self
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
