<?php

namespace App\Http\Livewire;

use App\Http\Requests\UpdateReplyRequest;
use App\Policies\ReplyPolicy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class EditReply extends Component
{
    use AuthorizesRequests;

    public $reply;

    public $body;

    public function render()
    {
        return view('livewire.edit-reply');
    }

    protected $listeners = ['submitted' => 'updateReply'];

    public function updateReply($body)
    {
        $this->body = $body;
        $this->authorize(ReplyPolicy::UPDATE, $this->reply);

        $this->validate((new UpdateReplyRequest())->rules());

        $this->reply->update([
            'body' => $this->body,
        ]);

        $this->emit('replyEdited');
    }
}
