<?php

namespace App\Http\Livewire;

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

    public function render()
    {
        $this->body = old('body', $this->body);

        return view('livewire.editor');
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
