<?php  namespace Lio\Bin\Validators;

use Illuminate\Validation\Factory;
use Lio\CommandBus\CommandValidationFailedException;

class CreateForkValidator
{
    private $validationFactory;

    public function __construct(Factory $validationFactory)
    {
        $this->validationFactory = $validationFactory;
    }

    public function validate($command)
    {
        $validator = $this->validationFactory->make(
            [
                'code' => $command->code,
                'parent' => $command->parent
            ],
            [
                'code' => 'required',
                'parent' => 'required'
            ]
        );

        if ($validator->fails()) {
            throw new CommandValidationFailedException($validator->messages()->toJson());
        }
    }
} 
