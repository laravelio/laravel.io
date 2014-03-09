<?php namespace Lio\Forum\Replies\Validators;

use Illuminate\Validation\Factory;
use Lio\CommandBus\CommandValidationFailedException;
use Lio\Forum\Replies\Commands\DeleteReplyCommand;

class DeleteReplyValidator
{
    private $validationFactory;

    public function __construct(Factory $validationFactory)
    {
        $this->validationFactory = $validationFactory;
    }

    public function validate(DeleteReplyCommand $command)
    {
        if ($command->reply->author_id != $command->user->id) {
            $errorJson = json_encode(['error' => 'User does not have permission to delete the reply.']);
            throw new CommandValidationFailedException($errorJson);
        }
    }
} 
