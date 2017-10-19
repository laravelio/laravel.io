<?php

namespace App\Validation;

use Illuminate\Validation\Factory as Validator;

class DoesNotContainUrlRule
{
    const NAME = 'not_contain_url';

    /**
     * @var \Illuminate\Validation\Factory
     */
    private $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function validate($attribute, $value): bool
    {
        return ! collect(explode(' ', $value))->contains(function ($word) {
            return $this->validator
                ->make(compact('word'), ['word' => 'url|required'])
                ->passes();
        });
    }
}
