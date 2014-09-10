<?php namespace Lio\Bin;

use Lio\Core\FormModel;

class PasteForm extends FormModel
{
    protected $validationRules = [
        'code' => 'required',
        'subject'  => 'size:0',
    ];
}
