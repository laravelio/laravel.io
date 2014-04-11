<?php namespace Lio\Forum\Threads\Validators;

use Lio\CommandBus\CommandValidationFailedException;
use Lio\Forum\Threads\Commands\MarkThreadUnsolvedCommand;

class MarkThreadUnsolvedValidator
{
    public function validate(MarkThreadUnsolvedCommand $command)
    {
        if ($command->thread->author_id != $command->user->id) {
            $errorJson = json_encode(['error' => 'User does not have permission to unsolve the thread.']);
            throw new CommandValidationFailedException($errorJson);
        }
    }
}
