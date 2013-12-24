<?php namespace Lio\Forum;

use Lio\Comments\CommentRepository;

/**
* This class can call the following methods on the observer object:
*
* forumThreadValidationError($errors)
* forumThreadCreated($thread)
*/
class ForumThreadCreator
{
    protected $comments;

    public function __construct(CommentRepository $comments)
    {
        $this->comments = $comments;
    }

    public function create(ForumThreadCreatorObserver $observer, $data, $validator = null)
    {
        // check the passed in validator
        if ($validator && ! $validator->isValid()) {
            return $observer->forumThreadValidationError($validator->getErrors());
        }
        return $this->createValidRecord($observer, $data);
    }

    private function createValidRecord($observer, $data)
    {
        $thread = $this->comments->getNew($data);

        // check the model validation
        if ( ! $this->comments->save($thread)) {
            return $observer->forumThreadValidationError($thread->getErrors());
        }

        if (isset($data['tags'])) {
            $this->attachTags($thread, $data['tags']);
        }

        return $observer->forumThreadCreated($thread);
    }

    private function attachTags($thread, $tags)
    {
        $thread->tags()->sync($tags->lists('id'));
    }
}