<?php namespace Lio\Comments;

use Lio\Core\FormModel;

class ReplyForm extends FormModel
{
    protected $validationRules = [
        'body'  => 'required',
    ];
}