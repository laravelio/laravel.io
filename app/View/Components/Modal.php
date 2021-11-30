<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public $identifier;

    public $title;

    public $action;

    public $type;

    public $submitLabel;

    public function __construct(string $identifier, string $title, string $action, string $type = 'delete', string $submitLabel = null)
    {
        $this->identifier = $identifier;
        $this->title = $title;
        $this->action = $action;
        $this->type = $type;
        $this->submitLabel = $submitLabel ?: $this->title;
    }

    public function render()
    {
        return view('components.modal');
    }

    public function method()
    {
        return match($this->type) {
            'delete' => 'delete',
            'update' => 'put',
            default => 'post',
        };
    }
}
