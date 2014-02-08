<?php namespace Lio\Forum\Replies;

class Reply extends \Lio\Core\Entity
{
    protected $table      = 'forum_replies';
    protected $fillable   = ['body', 'author_id', 'thread_id'];
    protected $with       = ['author'];
    protected $softDelete = true;

    public $presenter = 'Lio\Forum\Replies\ReplyPresenter';

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

    public function isOwnedBy($user)
    {
        if ( ! $user) return false;
        return $user->id == $this->author_id;
    }

    public function getPrecedingReplyCount()
    {
        return $this->newQuery()->where('thread_id', '=', $this->thread_id)->where('created_at', '<', $this->created_at)->count();
    }
}
