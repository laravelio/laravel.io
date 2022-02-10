<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Collection;
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

    public $hasMentions = false;

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

    public function getUsers($query): Collection
    {
        if (! $this->hasMentions) {
            return $this->users;
        }

        if (! $query) {
            return $this->users = $this->participants;
        }

        $query = Str::after($query, '@');
        $users = User::where('username', 'like', "{$query}%")->take(5)->get();

        if ($this->participants->isNotEmpty()) {
            $users = $this->participants->filter(function ($participant) use ($query) {
                return Str::startsWith($participant['username'], $query);
            })
                ->merge($users)
                ->unique('id');
        }

        return $this->users = $users;
    }

    public function getPreviewProperty(): string
    {
        return replace_links(md_to_html($this->body ?: ''));
    }

    public function preview(): void
    {
        $this->emit('previewRequested');
    }
}
