<?php namespace Lio\Forum;

class Reply extends \Lio\Core\Entity
{
    protected $table      = 'forum_replies';
    protected $fillable   = ['body', 'author_id', 'thread_id'];
    protected $with       = ['author'];
    protected $softDelete = true;

    public $presenter = 'Lio\Forum\ReplyPresenter';

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
        return $this->belongsTo('Lio\Forum\Thread', 'thread_id');
    }

    public function isOwnedBy(\Lio\Accounts\User $user)
    {
        return $user->id == $this->author_id;
    }
}
