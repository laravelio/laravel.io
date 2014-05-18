<?php namespace Lio\Core;

use Validator, App;
use Lio\Core\Exceptions\NoValidationRulesFoundException;

class FormModel
{
    protected $inputData;
    protected $validationRules;

    public function __construct()
    {
        $this->inputData = App::make('request')->all();
    }

    public function getInputData()
    {
        return $this->inputData;
    }

    public function isValid()
    {
        $this->beforeValidation();

        if ( ! isset($this->validationRules)) {
            throw new NoValidationRulesFoundException('no validation rules found in class ' . get_called_class());
        }

        $this->validator = Validator::make($this->getInputData(), $this->getPreparedRules());

        return $this->validator->passes();
    }

    public function getErrors()
    {
        return $this->validator->errors();
    }

    protected function getPreparedRules()
    {
        return $this->validationRules;
    }

    protected function beforeValidation() {}
}
