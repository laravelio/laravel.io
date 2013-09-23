<?php namespace Lio\Articles;

use Lio\Core\FormBase;

class ArticleForm extends FormBase
{
    protected $validationRules = [
        'title'   => 'required|min:10',
        'content' => 'required',
    ];
}