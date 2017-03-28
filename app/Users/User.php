<?php

namespace App\Users;

use App\Exceptions\CannotCreateUser;
use App\Forum\Thread;
use App\Helpers\HasTimestamps;
use App\Helpers\ModelHelpers;
use App\Replies\HasManyReplies;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasManyReplies, HasTimestamps, ModelHelpers, Notifiable;

    const DEFAULT = 1;
    const MODERATOR = 2;
    const ADMIN = 3;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
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
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
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

    public function isAdmin(): bool
    {
        return $this->type() === self::ADMIN;
    }

    /**
     * @return \App\Forum\Thread[]
     */
    public function threads()
    {
        return $this->threadsRelation;
    }

    /**
     * @return \App\Forum\Thread[]
     */
    public function latestThreads(int $amount = 3)
    {
        return $this->threadsRelation->take($amount);
    }

    public function threadsRelation(): HasMany
    {
        return $this->hasMany(Thread::class, 'author_id');
    }

    public function countThreads(): int
    {
        return $this->threadsRelation()->count();
    }

    public function countReplies(): int
    {
        return $this->replyAble()->count();
    }

    /**
     * @todo Make this work with Eloquent instead of a collection
     */
    public function countSolutions(): int
    {
        return $this->threads()->filter(function (Thread $thread) {
            if ($solutionReply = $thread->solutionReply()) {
                return $solutionReply->isAuthoredBy($this);
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

    public static function createFromData(UserData $data): User
    {
        static::assertEmailAddressIsUnique($data->emailAddress());
        static::assertUsernameIsUnique($data->username());

        $user = new static();
        $user->name = $data->name();
        $user->email = $data->emailAddress();
        $user->username = $data->username();
        $user->password = $data->password();
        $user->ip = $data->ip();
        $user->github_id = $data->githubId();
        $user->github_url = $data->githubUsername();
        $user->confirmation_code = str_random(60);
        $user->type = static::DEFAULT;
        $user->save();

        return $user;
    }

    private static function assertEmailAddressIsUnique(string $emailAddress)
    {
        try {
            User::findByEmailAddress($emailAddress);
        } catch (ModelNotFoundException $exception) {
            return true;
        }

        throw CannotCreateUser::duplicateEmailAddress($emailAddress);
    }

    private static function assertUsernameIsUnique(string $username)
    {
        try {
            User::findByUsername($username);
        } catch (ModelNotFoundException $exception) {
            return true;
        }

        throw CannotCreateUser::duplicateUsername($username);
    }
}
