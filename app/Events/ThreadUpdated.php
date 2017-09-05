<?php

namespace App\Events;

use App\Models\Thread;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Realtime socket event for updating a Thread
 * Class ThreadUpdated
 * @package App\Events
 */
class ThreadUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    /**
     * @var \App\User
     */
    protected $user;
    /**
     * @var Thread
     */
    protected $thread;
    
    /**
     * ThreadUpdated constructor.
     * @param Thread $thread
     */
    public function __construct(Thread $thread)
    {
        $this->user = $thread->author();
        $this->thread = $thread;
    }
    
    /**
     * Cast the data to socket
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'thread' => $this->thread,
            'author' => $this->user
        ];
    }
    
    
    /**
     * Broadcast this event as ThreadUpdated event
     * @return string
     */
    public function broadcastAs()
    {
        return 'ThreadUpdated';
    }
    
    /**
     * Get the channels the event should broadcast on.
     * This would be in this case : Private and Public channel
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return [
            new Channel('threads'),
        ];
    }
}
