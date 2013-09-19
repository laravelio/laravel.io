<?php namespace Lio\Forum;

use Lio\Core\FormBase;

class ReplyForm extends FormBase
{
    protected $validationRules = [
        'body'  => 'required',
    ];
}