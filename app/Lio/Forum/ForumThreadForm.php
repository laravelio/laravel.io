<?php namespace Lio\Forum;

use Lio\Core\FormBase;
use App, Validator;

class ForumThreadForm extends FormBase
{
    protected $validationRules = [
        'title'           => 'required|min:10',
        'body'            => 'required',
        'tags'            => 'required|max_tags:3',
        'laravel_version' => 'required|in:0,3,4',
    ];

    protected function beforeValidation()
    {
        Validator::extend('max_tags', function($attribute, $tagIds, $params) {
            $maxCount = $params[0];

            $tagRepo = App::make('Lio\Tags\TagRepository');
            $tags = $tagRepo->getTagsByIds($tagIds);

            if ($tags->count() > $maxCount) {
                return false;
            }

            return true;
        });
    }
}