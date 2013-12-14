<?php namespace Lio\Articles;

use Lio\Core\FormBase;

class ArticleForm extends FormBase
{
    protected $validationRules = [
        'title'           => 'required|min:10',
        'content'         => 'required',
        'laravel_version' => 'required',
        'status'          => 'required',
        'tags'            => 'required|max_tags:3',
    ];


    protected function beforeValidation()
    {
        \Validator::extend('max_tags', function($attribute, $tagIds, $params) {
            $maxCount = $params[0];

            $tagRepo = \App::make('Lio\Tags\TagRepository');
            $tags = $tagRepo->getTagsByIds($tagIds);

            if ($tags->count() > $maxCount) {
                return false;
            }

            return true;
        });
    }
}