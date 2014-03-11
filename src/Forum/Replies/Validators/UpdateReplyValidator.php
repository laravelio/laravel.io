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
        if ($command->reply->author_id != $command->user->id) {
            $errorJson = json_encode(['error' => 'User does not have permission to update the reply.']);
            throw new CommandValidationFailedException($errorJson);
        }

        $validator = $this->validationFactory->make(
            [
                'body' => $command->body,
                'user' => $command->user->id,
            ], [
                'body' => 'required',
                'user' => 'exists:users,id',
            ]
        );

        if ($validator->fails()) {
            throw new CommandValidationFailedException($validator->messages()->toJson());
        }
    }
}
