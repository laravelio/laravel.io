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

    public function update($data)
    {
        $this->authorize(ReplyPolicy::UPDATE, $this->reply);
        $this->body = $data['body'];

        
        $this->validate((new UpdateReplyRequest())->rules());

        $this->reply->update([
            'body' => $this->body,
        ]);
    }
}
