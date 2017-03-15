<?php

namespace Lio\Forum\Threads;

use Lio\Core\Entity;

class ThreadVisitation extends Entity
{
    protected $table = 'forum_thread_visitations';
    protected $fillable = ['user_id', 'thread_id', 'visited_at'];

    protected $validationRules = [
        'user_id'    => 'required|exists:users,id',
        'thread_id'  => 'required|exists:forum_threads,id',
        'visited_at' => 'required',
    ];
}
