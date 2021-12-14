<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public $submitLabel;

    public function __construct(
        public string $identifier,
        public string $title,
        public string $action,
        public string $type = 'delete',
        string $submitLabel = null
    ) {
        $this->submitLabel = $submitLabel ?: $this->title;
    }

    public function render()
    {
        return view('components.modal');
    }

    public function method()
    {
        return match ($this->type) {
            'delete' => 'delete',
            'update' => 'put',
            default => 'post',
        };
    }
}
