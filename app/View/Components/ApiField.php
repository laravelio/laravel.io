<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ApiField extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $token;
    
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.api-field');
    }
}
