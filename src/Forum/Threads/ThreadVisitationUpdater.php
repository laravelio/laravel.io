<?php namespace Lio\Forum\Threads;

use Lio\Accounts\User;

class ThreadVisitationUpdater
{
    public function update(Thread $thread, User $user)
    {
        $visitation = $this->getVisitation($thread, $user);

        if ( ! $visitation) {
            return $this->createVisitation($thread, $user);
        }

        $visitation->visited_at = strtotime('now');
        $visitation->save();
    }
}
