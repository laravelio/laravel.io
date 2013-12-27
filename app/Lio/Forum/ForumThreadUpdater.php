<?php namespace Lio\Forum;

use Lio\Comments\CommentRepository;

/**
* This class can call the following methods on the observer object:
*
* forumThreadValidationError($errors)
* forumThreadUpdated($thread)
*/
class ForumThreadUpdater
{
    protected $comments;

    public function __construct(CommentRepository $comments)
    {
        $this->comments = $comments;
    }

    public function update(ForumThreadUpdaterObserver $observer, $thread, $data, $validator = null)
    {
        // check the passed in validator
        if ($validator && ! $validator->isValid()) {
            return $observer->forumThreadValidationError($validator->getErrors());
        }
        return $this->updateRecord($thread, $observer, $data);
    }

    private function updateRecord($thread, $observer, $data)
    {
        $thread->fill($data);

        // check the model validation
        if ( ! $this->comments->save($thread)) {
            return $observer->forumThreadValidationError($thread->getErrors());
        }

        if (isset($data['tags'])) {
            $this->attachTags($thread, $data['tags']);
        }

        return $observer->forumThreadUpdated($thread);
    }

    private function attachTags($thread, $tags)
    {
        $thread->tags()->sync($tags->lists('id'));
    }
}