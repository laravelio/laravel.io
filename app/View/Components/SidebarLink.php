<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SidebarLink extends Component
{
    public $to;

    public $label;

    public $icon;

    public $active;

    public function __construct($to, $label, $icon, $active)
    {
        $this->to = $to;
        $this->label = $label;
        $this->icon = $icon;
        $this->active = $active;
    }

    public function render()
    {
        return view('components.sidebar-link');
    }
}
