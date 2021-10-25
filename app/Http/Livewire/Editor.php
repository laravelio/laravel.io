<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Editor extends Component
{
    public $label;

    public $body = '';

    public $enableActionButton = false;

    public $actionButtonLabel = 'Submit';

    public $actionButtonType = 'submit';

    public $actionButtonIcon;

    public function render()
    {
        return view('livewire.editor');
    }

    public function getPreviewProperty()
    {
        return replace_links(md_to_html($this->body));
    }

    public function preview()
    {
        $this->emit('previewRequested');
    }
}
