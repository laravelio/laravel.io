<?php namespace Lio\Forum;

use Lio\Comments\CommentRepository;

/**
* This class can call the following methods on the observer object:
*
* forumReplyValidationError($errors)
* forumReplyUpdated($reply)
*/
class ForumReplyUpdater
{
    protected $comments;

    public function __construct(CommentRepository $comments)
    {
        $this->comments = $comments;
    }

    public function update($reply, ForumReplyUpdaterObserver $observer, $data, $validator = null)
    {
        // check the passed in validator
        if ($validator && ! $validator->isValid()) {
            return $observer->forumReplyValidationError($validator->getErrors());
        }
        return $this->updateRecord($reply, $observer, $data);
    }

    private function updateRecord($reply, $observer, $data)
    {
        $reply->fill($data);

        // check the model validation
        if ( ! $this->comments->save($reply)) {
            return $observer->forumReplyValidationError($reply->getErrors());
        }

        return $observer->forumReplyUpdated($reply);
    }
}