<?php namespace Lio\Forum;

use Lio\Comments\CommentRepository;

/**
* This class can call the following methods on the observer object:
*
* forumReplyValidationError($errors)
* forumReplyCreated($reply)
*/
class ForumReplyCreator
{
    protected $comments;

    public function __construct(CommentRepository $comments)
    {
        $this->comments = $comments;
    }

    public function create(ForumReplyCreatorObserver $observer, $data, $validator = null)
    {
        // check the passed in validator
        if ($validator && ! $validator->isValid()) {
            return $observer->forumReplyValidationError($validator->getErrors());
        }
        return $this->createValidRecord($observer, $data);
    }

    private function createValidRecord($observer, $data)
    {
        $reply = $this->comments->getNew($data);
        $reply->parent_id = $data['thread']->id;

        // check the model validation
        if ( ! $this->comments->save($reply)) {
            return $observer->forumReplyValidationError($reply->getErrors());
        }

        return $observer->forumReplyCreated($reply);
    }
}