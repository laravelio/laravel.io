<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DangerButton extends Component
{
    public $type;

    public function __construct(?string $type = 'button')
    {
        $this->type = $type;
    }

    public function render()
    {
        return view('components.buttons.danger-button');
    }
}
