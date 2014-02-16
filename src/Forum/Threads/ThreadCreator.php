<?php namespace Lio\Forum\Threads;

/**
* This class can call the following methods on the listener object:
*
* threadCreationError($errors)
* threadCreated($thread)
*/
class ThreadCreator
{
    protected $threads;

    public function __construct(ThreadRepository $threads)
    {
        $this->threads = $threads;
    }

    // an additional validator is optional and will be run first, an example of a usage for
    // this is a form validator
    public function create(ThreadCreatorListener $listener, $data, $validator = null)
    {
        if ($validator && ! $validator->isValid()) {
            return $listener->threadCreationError($validator->getErrors());
        }
        return $this->createValidRecord($listener, $data);
    }

    private function createValidRecord($listener, $data)
    {
        $thread = $this->getNew($data);
        $this->validateAndSave($thread, $listener, $data);

        return $listener->threadCreated($thread);
    }

    private function getNew($data)
    {
        return $this->threads->getNew($data + [
            'author_id' => $data['author']->id,
        ]);
    }

    private function validateAndSave($thread, $listener, $data)
    {
        // check the model validation
        if ( ! $this->threads->save($thread)) {
            return $listener->threadValidationError($thread->getErrors());
        }

        // attach any tags that were passed through
        if (isset($data['tags'])) {
            $thread->setTags($data['tags']->lists('id'));
        }
    }
}
