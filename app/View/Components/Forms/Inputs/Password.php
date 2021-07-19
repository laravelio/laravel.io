<?php

declare(strict_types=1);

namespace App\View\Components\Forms\Inputs;

use BladeUIKit\Components\Forms\Inputs\Password as Component;
use Illuminate\Contracts\View\View;

final class Password extends Component
{
    public function render(): View
    {
        return view('components.forms.inputs.password');
    }
}
