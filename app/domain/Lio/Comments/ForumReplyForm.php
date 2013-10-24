<?php namespace Lio\Comments;

use Lio\Core\FormBase;

class ForumReplyForm extends FormBase
{
    protected $validationRules = [
        'body'  => 'required',
    ];
}