<?php

namespace Lio\Bin;

use Lio\Core\FormModel;

class PasteForm extends FormModel
{
    protected $validationRules = [
        'code'     => 'required',
        'password' => 'size:0',
    ];
}
