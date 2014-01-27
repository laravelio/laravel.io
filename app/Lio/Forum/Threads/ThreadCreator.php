<?php namespace Lio\Forum\Threads;

use Lio\Forum\SectionCountManager;

/**
* This class can call the following methods on the observer object:
*
* threadCreationError($errors)
* threadCreated($thread)
*/
class ThreadCreator
{
    protected $threads;
    protected $countManager;

    public function __construct(ThreadRepository $threads, SectionCountManager $countManager)
    {
        $this->threads = $threads;
        $this->countManager = $countManager;
    }

    // an additional validator is optional and will be run first, an example of a usage for
    // this is a form validator
    public function create(ThreadCreatorListener $observer, $data, $validator = null)
    {
        if ($validator && ! $validator->isValid()) {
            return $observer->threadCreationError($validator->getErrors());
        }
        return $this->createValidRecord($observer, $data);
    }

    private function createValidRecord($observer, $data)
    {
        $thread = $this->getNew($data);
        $this->validateAndSave($thread, $observer);

        // cache new thread update timestamps
        $this->countManager->cacheSections();

        return $observer->threadCreated($thread);
    }

    private function getNew($data)
    {
        return $this->threads->getNew($data + [
            'author_id' => $data['author']->id,
        ]);
    }

    private function validateAndSave($thread, $observer)
    {
        // check the model validation
        if ( ! $this->threads->save($thread)) {
            return $observer->threadValidationError($thread->getErrors());
        }

        // attach any tags that were passed through
        if (isset($data['tags'])) {
            $thread->setTags($data['tags']->lists('id'));
        }
    }
}