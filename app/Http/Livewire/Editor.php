<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
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

    public $hasShadow = true;

    public $users = [];

    public $participants = [];

    public function mount(EloquentCollection $participants = null)
    {
        $this->participants = $participants ? $participants->toArray() : [];
    }

    public function render()
    {
        $this->body = old('body', $this->body);

        return view('livewire.editor');
    }

    public function getUsers($query): array
    {
        if (! $this->hasMentions) {
            return [];
        }

        if (! $query) {
            return $this->users = $this->participants;
        }

        $query = Str::after($query, '@');
        $users = User::where('username', 'like', "{$query}%")->take(5)->get();

        if (count($this->participants) > 0) {
            $users = collect($this->participants)->filter(function ($participant) use ($query) {
                return Str::startsWith($participant['username'], $query);
            })
                ->merge($users)
                ->unique('id');
        }

        return $this->users = $users->toArray();
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
