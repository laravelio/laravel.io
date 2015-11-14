<?php
namespace Lio\Users;

use Lio\DateTime\Timestamps;

interface User extends Timestamps
{
    /**
     * @return int
     */
    public function id();

    /**
     * @return string
     */
    public function name();

    /**
     * @return string
     */
    public function githubUsername();

    /**
     * @return \Lio\Replies\Reply[]
     */
    public function replies();
}
