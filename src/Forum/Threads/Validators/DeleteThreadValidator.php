<?php namespace Lio\Forum\Threads\Validators; 

use Lio\CommandBus\CommandValidationFailedException;
use Lio\Forum\Threads\Commands\DeleteThreadCommand;

class DeleteThreadValidator
{
    public function validate(DeleteThreadCommand $command)
    {
        if ($command->thread->author_id != $command->user->id) {
            $errorJson = json_encode(['error' => 'User does not have permission to delete the thread.']);
            throw new CommandValidationFailedException($errorJson);
        }
    }
}
