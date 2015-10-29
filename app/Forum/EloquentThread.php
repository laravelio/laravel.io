<?php
namespace Lio\Forum;

use Illuminate\Database\Eloquent\Model;

final class EloquentThread extends Model implements Thread
{
    /**
     * @var string
     */
    protected $table = 'forum_threads';

    /**
     * @return string
     */
    public function subject()
    {
        return $this->subject;
    }
}
