<?php namespace Lio\Forum\Replies;

use Lio\Core\FormModel;
use Validator;

class ReplyForm extends FormModel
{
    protected $validationRules = [
        'body'  => 'required',
        '_time' => 'required|min_time:2',
        '_type' => 'required',
    ];

    protected function beforeValidation()
    {
        Validator::extend('min_time', function ($attribute, $time, $params) {
            $minTime = $params[0];

            if ($this->inputData['_type'] == 'edit') {
                return true;
            }

            return (time() - $time) > $minTime;
        });
    }
}
