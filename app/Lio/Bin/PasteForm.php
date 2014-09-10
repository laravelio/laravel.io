<?php namespace Lio\Bin;

use Lio\Core\FormModel;

class PasteForm extends FormModel
{
    protected $validationRules = [
        'paste_data' => 'required',
        'password'  => 'size:0',
    ];
}
