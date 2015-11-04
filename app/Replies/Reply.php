<?php
namespace Lio\Replies;

interface Reply
{
    /**
     * @return string
     */
    public function body();

    /**
     * @return \Lio\Users\User
     */
    public function author();
}
