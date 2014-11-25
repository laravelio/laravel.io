<?php namespace Lio\Forum\Threads;

use Lio\Core\FormModel;
use App, Validator;

class ThreadForm extends FormModel
{
    protected $validationRules = [
        'subject' => 'required|min:10|no_phone',
        'body' => 'required|no_phone',
        'tags' => 'required|max_tags:3',
        'is_question' => 'in:0,1',
        'laravel_version' => 'required|in:0,3,4',
        '_time' => 'required|min_time:5',
        '_type' => 'required',
    ];

    protected function beforeValidation()
    {
        Validator::extend('max_tags', function ($attribute, $tagIds, $params) {
            $maxCount = $params[0];

            $tagRepo = App::make('Lio\Tags\TagRepository');
            $tags = $tagRepo->getTagsByIds($tagIds);

            if ($tags->count() > $maxCount) {
                return false;
            }

            return true;
        });

        Validator::extend('min_time', function ($attribute, $time, $params) {
            $minTime = $params[0];

            if ($this->inputData['_type'] == 'create') {
                return (time() - $time) > $minTime;
            }

            return true;
        });

        Validator::extend('no_phone', function ($attribute, $text, $params) {
           return ! preg_match('\+?(\d{1,3}[-.\s]?)?\d{3}[-.\s]?\d{3}[-.\s]?\d{4}', $text);
        });
    }
}
