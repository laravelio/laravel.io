<?php namespace Lio\Forum;

use Lio\Core\FormBase;

class ThreadForm extends FormBase
{
    protected $validationRules = [
        'title' => 'required|min:10',
        'body'  => 'required',
    ];
}