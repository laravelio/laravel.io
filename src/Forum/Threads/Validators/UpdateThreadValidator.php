<?php namespace Lio\Forum\Threads\Validators; 

use Illuminate\Validation\Factory;
use Lio\CommandBus\CommandValidationFailedException;
use Lio\Forum\Threads\Commands\UpdateThreadCommand;

class UpdateThreadValidator
{
    private $validationFactory;

    public function __construct(Factory $validationFactory)
    {
        $this->validationFactory = $validationFactory;
    }

    public function validate(UpdateThreadCommand $command)
    {
        if ($command->thread->author_id != $command->user->id) {
            $errorJson = json_encode(['error' => 'User does not have permission to update the thread.']);
            throw new CommandValidationFailedException($errorJson);
        }

        $validator = $this->validationFactory->make(
            [
                'subject' => $command->subject,
                'body' => $command->body,
                'tags' => $command->tagIds,
                'isQuestion' => $command->isQuestion,
                'laravelVersion' => $command->laravelVersion,
                'user' => $command->user->id,
            ], [
                'subject' => 'required|min:10',
                'body' => 'required',
                'tags' => 'required|max_tags:3',
                'isQuestion' => 'in:0,1',
                'laravelVersion' => 'required|in:0,3,4',
                'user' => 'exists:users,id',
            ]
        );

        if ($validator->fails()) {
            throw new CommandValidationFailedException($validator->messages()->toJson());
        }
    }
} 
