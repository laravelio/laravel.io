<?php namespace Lio\Forum\Replies\Validators;

use Illuminate\Validation\Factory;
use Lio\CommandBus\CommandValidationFailedException;
use Lio\Forum\Replies\Commands\UpdateReplyCommand;

class UpdateReplyValidator
{
    private $validationFactory;

    public function __construct(Factory $validationFactory)
    {
        $this->validationFactory = $validationFactory;
    }

    public function validate(UpdateReplyCommand $command)
    {
        $validator = $this->validationFactory->make(
            [
                'body' => $command->body,
            ],
            [
                'body'  => 'required',
            ]
        );

        if ($validator->fails()) {
            throw new CommandValidationFailedException($validator->messages()->toJson());
        }
    }
}
