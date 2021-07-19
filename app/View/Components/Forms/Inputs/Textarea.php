<?php

declare(strict_types=1);

namespace App\View\Components\Forms\Inputs;

use BladeUIKit\Components\Forms\Inputs\Textarea as Component;
use Illuminate\Contracts\View\View;

final class Textarea extends Component
{
    public function render(): View
    {
        return view('components.forms.inputs.textarea');
    }
}
