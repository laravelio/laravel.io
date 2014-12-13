<?php namespace Lio\Forum\Replies;

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Lio\Core\Entity;
use McCool\LaravelAutoPresenter\PresenterInterface;

class Reply extends Entity implements PresenterInterface
{
    use SoftDeletingTrait;

    protected $table    = 'forum_replies';
    protected $fillable = ['body', 'author_id', 'thread_id', 'ip'];
    protected $with     = ['author'];
    protected $dates    = ['deleted_at'];

    protected $validationRules = [
        'body'      => 'required|min:6',
        'author_id' => 'required|exists:users,id',
    ];

    public function author()
    {
        return $this->belongsTo('Lio\Accounts\User', 'author_id');
    }

    public function thread()
    {
        return $this->belongsTo('Lio\Forum\Threads\Thread', 'thread_id');
    }

    public function isManageableBy($user)
    {
        if ( ! $user) return false;
        return $this->isOwnedBy($user) || $user->isForumAdmin();
    }

    public function isOwnedBy($user)
    {
        if ( ! $user) return false;
        return $user->id == $this->author_id;
    }

    public function getPrecedingReplyCount()
    {
        return $this->newQuery()->where('thread_id', $this->thread_id)->where('created_at', '<', $this->created_at)->count();
    }

    /**
     * Get the presenter class.
     *
     * @return string The class path to the presenter.
     */
    public function getPresenter()
    {
        return 'Lio\Forum\Replies\ReplyPresenter';
    }
}
