<?php
namespace Lio\Forum;

use Lio\DateTime\Timestamps;

interface Thread extends Timestamps
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
    public function body();

    /**
     * @return string
     */
    public function slug();

    /**
     * @return \Lio\Replies\Reply[]
     */
    public function replies();
}
