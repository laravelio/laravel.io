<?php namespace Lio\Forum\Threads\Validators; 

use Illuminate\Validation\Factory;
use Lio\CommandBus\CommandValidationFailedException;
use Lio\Forum\Threads\Commands\CreateThreadCommand;

class CreateThreadValidator
{
    private $validationFactory;

    public function __construct(Factory $validationFactory)
    {
        $this->validationFactory = $validationFactory;
    }

    public function validate(CreateThreadCommand $command)
    {
        $validator = $this->validationFactory->make(
            [
                'subject' => $command->subject,
                'body' => $command->body,
                'tags' => $command->tagIds,
                'isQuestion' => $command->isQuestion,
                'laravelVersion' => $command->laravelVersion,
            ],
            [
                'subject' => 'required|min:10',
                'body' => 'required',
                'tags' => 'required|max_tags:3',
                'isQuestion' => 'in:0,1',
                'laravelVersion' => 'required|in:0,3,4',
            ]
        );

        if ($validator->fails()) {
            throw new CommandValidationFailedException($validator->messages()->toJson());
        }
    }
} 
