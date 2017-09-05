<?php

namespace App\Events;

use App\Models\Reply;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Realtime socket event for updating a Reply
 * Class ReplyUpdated
 * @package App\Events
 */
class ReplyUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    /**
     * @var \App\User
     */
    protected $user;
    /**
     * @var Reply
     */
    protected $reply;
    
    /**
     * ReplyUpdated constructor.
     * @param Reply $reply
     */
    public function __construct(Reply $reply)
    {
        $this->user = $reply->author();
        $this->thread = $reply;
    }
    
    /**
     * Cast the data to socket
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'reply' => $this->reply,
            'author' => $this->user
        ];
    }
    
    
    /**
     * Broadcast this event as ReplyUpdated event
     * @return string
     */
    public function broadcastAs()
    {
        return 'ReplyUpdated';
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
