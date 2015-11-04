<?php
namespace Lio\Forum;

interface Thread
{
    const TYPE = 'threads';

    /**
     * @return int
     */
    public function id();

    /**
     * @return string
     */
    public function subject();

    /**
     * @return string
     */
    public function slug();

    /**
     * @return \Lio\Replies\Reply[]
     */
    public function replies();
}
