<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Component;

class Editor extends Component
{
    public $label;

    public $placeholder = 'Write a reply...';

    public $body;

    public $hasButton;

    public $buttonType = 'submit';

    public $buttonLabel = 'Submit';

    public $buttonIcon;

    public $users;

    public $participants;

    public function mount($participants = null)
    {
        $this->users = collect();
        $this->participants = $participants ?: collect();
    }

    public function render()
    {
        $this->body = old('body', $this->body);

        return view('livewire.editor');
    }

    public function getUsers($search)
    {
        if (! $search) {
            return $this->users = $this->participants;
        }

        $search = Str::after($search, '@');
        $users = User::where('username', 'like', "{$search}%")->take(5)->get();

        if ($this->participants->isNotEmpty()) {
            $users = $this->participants->filter(function ($participant) use ($search) {
                return Str::startsWith($participant->username(), $search);
            })
                ->merge($users)
                ->unique('id');
        }

        return $this->users = $users;
    }

    public function getPreviewProperty()
    {
        return replace_links(md_to_html($this->body ?: ''));
    }

    public function preview()
    {
        $this->emit('previewRequested');
    }
}
