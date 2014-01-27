<?php namespace Lio\Forum\Replies;

use Lio\Core\FormModel;

class ReplyForm extends FormModel
{
    protected $validationRules = [
        'body'  => 'required',
    ];
}