<?php
namespace Lio\Replies;

use Lio\DateTime\Timestamps;

interface Reply extends Timestamps
{
    /**
     * @return int
     */
    public function id();

    /**
     * @return string
     */
    public function body();

    /**
     * @return \Lio\Users\User
     */
    public function author();

    /**
     * @return \Lio\Replies\ReplyAble
     */
    public function replyAble();
}
