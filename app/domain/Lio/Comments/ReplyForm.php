<?php namespace Lio\Comments;

use Lio\Core\FormBase;

class ReplyForm extends FormBase
{
    protected $validationRules = [
        'body'  => 'required',
    ];
}