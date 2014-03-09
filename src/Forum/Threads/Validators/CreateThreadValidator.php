<?php namespace Lio\Forum\Threads\Validators; 

use Lio\CommandBus\CommandValidationFailedException;
use Lio\Forum\Threads\Commands\CreateThreadCommand;

class CreateThreadValidator
{
    public function validate(CreateThreadCommand $command)
    {
        $validator = \Validator::make(
            [
                'subject' => $command->subject,
                'body' => $command->body,
            ],
            [
                'subject' => 'required',
                'body' => 'required|min:8',
            ]
        );

        if ($validator->fails()) {
            throw new CommandValidationFailedException(json_encode($validator->messages()->toArray()));
        }
    }
} 
