<?php namespace Lio\Core;

use Validator, Eloquent;
use Lio\Core\Exceptions\NoValidationRulesFoundException;
use Lio\Core\Exceptions\NoValidatorInstantiatedException;

class EloquentBaseModel extends Eloquent
{
    protected $validationRules = [];
    protected $validator;

    public function isValid()
    {
        if ( ! $this->validationRules) {
            throw new NoValidationRulesFoundException('No validation rules found in class ' . get_called_class());
        }

        $this->validator = Validator::make($this->getAttributes(), $this->getPreparedRules());

        return $this->validator->passes();
    }

    public function getErrors()
    {
        if ( ! $this->validator) {
            throw new NoValidatorInstantiatedException;
        }

        return $this->validator->errors();
    }

    protected function getPreparedRules()
    {
        return $this->replaceIdsIfExists($this->validationRules);
    }

    protected function replaceIdsIfExists($rules)
    {
        $newRules = [];

        foreach ($rules as $key => $rule) {
            if (str_contains($rule, '<id>')) {
                $replacement = $this->exists ? $this->getAttribute($this->primaryKey) : '';

                $rule = str_replace('<id>', $replacement, $rule);
            }

            array_set($newRules, $key, $rule)
        }

        return $preparedRules;
    }
}
