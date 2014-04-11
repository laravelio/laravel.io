<?php namespace Lio\Forum\Threads\Validators;

use Lio\CommandBus\CommandValidationFailedException;
use Lio\Forum\Threads\Commands\MarkThreadSolvedCommand;

class MarkThreadSolvedValidator
{
    public function validate(MarkThreadSolvedCommand $command)
    {
        if ($command->thread->author_id != $command->user->id) {
            $errorJson = json_encode(['error' => 'User does not have permission to solve the thread.']);
            throw new CommandValidationFailedException($errorJson);
        }
    }
}
