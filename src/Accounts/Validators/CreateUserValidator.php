<?php namespace Lio\Accounts\Validators;

use Illuminate\Validation\Factory;
use Lio\Accounts\Commands\CreateUserCommand;
use Lio\CommandBus\CommandValidationFailedException;

class CreateUserValidator
{
    private $validationFactory;

    public function __construct(Factory $validationFactory)
    {
        $this->validationFactory = $validationFactory;
    }

    public function validate(CreateUserCommand $command)
    {
        $validator = $this->validationFactory->make(
            [
                'github_id' => $command->githubId,
            ], [
                'github_id' => 'unique:users,github_id',
            ]
        );

        if ($validator->fails()) {
            throw new CommandValidationFailedException($validator->messages()->toJson());
        }
    }
}
