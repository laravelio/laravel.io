<?php namespace Lio\Forum;

use Lio\Core\FormBase;

class ForumReplyForm extends FormBase
{
    protected $validationRules = [
        'body'  => 'required',
    ];
}