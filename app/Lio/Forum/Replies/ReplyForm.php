<?php namespace Lio\Forum\Replies;

use Lio\Core\FormModel;
use Input;

class ReplyForm extends FormModel
{
    protected $validationRules = [
        'body'  => 'required',
    ];

    protected function beforeValidation()
    {
        $time = Input::get('_time');

        // Conditional validation rule:
        //   - compare processing time to form-creation time
        //   - if the difference is less than 2 seconds
        //   - we apply a rule where the max length of the _time input is 0
        //   - and then validation will fail because it is not 0
        Validator::sometimes('_time', 'max:0', function() use ($time)
        {
            return (strtotime("now") - $time) < 2;
        });
    }
}