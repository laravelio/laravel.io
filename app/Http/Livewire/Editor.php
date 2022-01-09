<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;

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

    public function mount()
    {
        $this->users = collect();
    }

    public function render()
    {
        $this->body = old('body', $this->body);

        return view('livewire.editor');
    }

    public function getUsers($search)
    {
        if (! $search) {
            return $this->users = collect();
        }

        $search = Str::after($search, '@');

        return $this->users = User::where('username', 'like', "{$search}%")->take(5)->get();
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
