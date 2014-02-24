<?php namespace Lio\Forum\Threads;
use Lio\Core\EventDispatcher;
use Lio\Notifications\Tasks\SearchNewForumPostForForumUserTags;

/**
* This class can call the following methods on the listener object:
*
* threadCreationError($errors)
* threadCreated($thread)
*/
class ThreadCreator
{
    use EventDispatcher;

    private $threads;
    private $responder;

    public function __construct(ThreadRepository $threads)
    {
        $this->threads = $threads;
    }

    public function setResponder(ThreadCreatorResponder $responder)
    {
        $this->responder = $responder;
    }

    public function create($data, $validator = null)
    {
        if ($validator && ! $validator->isValid()) {
            return $this->failure($validator->getErrors());
        }
        return $this->createValidRecord($data);
    }

    private function createValidRecord($data)
    {
        $thread = $this->getNew($data);
        $this->validateAndSave($thread, $data);
        $this->fireEvents($thread);
        return $this->success($thread);
    }

    private function getNew($data)
    {
        return $this->threads->getNew($data + [
            'author_id' => $data['author']->id,
        ]);
    }

    private function validateAndSave($thread, $data)
    {
        // check the model validation
        if ( ! $this->threads->save($thread)) {
            return $this->failure($thread->getErrors());
        }

        // attach any tags that were passed through
        if (isset($data['tags'])) {
            $thread->setTags($data['tags']->lists('id'));
        }
    }

    private function fireEvents($thread)
    {
        $this->addEvent(new SearchNewForumPostForForumUserTags($thread));
        $this->dispatchEvents();
    }

    private function failure($errors)
    {
        if ($this->responder) {
            return $this->responder->threadValidationError($errors);
        }
    }

    private function success($thread)
    {
        if ($this->responder) {
            return $this->responder->threadCreated($thread);
        }
    }
}
