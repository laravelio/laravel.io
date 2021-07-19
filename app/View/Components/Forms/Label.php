<?php

declare(strict_types=1);

namespace App\View\Components\Forms;

use BladeUIKit\Components\Forms\Label as Component;
use Illuminate\Contracts\View\View;

final class Label extends Component
{
    public function render(): View
    {
        return view('components.forms.label');
    }
}
