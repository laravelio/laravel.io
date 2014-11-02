<?php namespace Lio\Forum\Replies;

use Lio\Core\FormModel;
use Validator;

class ReplyForm extends FormModel
{
    protected $validationRules = [
        'body'  => 'required',
        '_time' => 'min_time:2',
    ];

    public function beforeValidation()
    {
        $type = isset($this->inputData['_type']) ? $this->inputData['_type'] : null;

        // Time validation on Create forms
        if ($type === 'create') {
            Validator::extend('min_time', function ($attribute, $time, $params) {
                $minTime = $params[0];

                return (time() - $time) > $minTime;
            });
        }
    }
}