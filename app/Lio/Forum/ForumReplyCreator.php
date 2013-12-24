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

        // check the model validation
        if ( ! $this->comments->save($reply)) {
            return $observer->forumReplyValidationError($reply->getErrors());
        }

        $this->attachReply($reply, $data['thread']);

        return $observer->forumReplyCreated($reply);
    }

    private function attachReply($reply, $thread)
    {
        $thread->children()->save($reply);
    }
}