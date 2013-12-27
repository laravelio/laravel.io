<?php namespace Lio\Forum;

use Lio\Forum\ForumSectionCountManager;
use Lio\Comments\CommentRepository;
use Lio\Comments\Comment;

/**
* This class can call the following methods on the observer object:
*
* forumReplyValidationError($errors)
* forumReplyCreated($reply)
*/
class ForumReplyCreator
{
    protected $comments;
    protected $countManager;

    public function __construct(CommentRepository $comments, ForumSectionCountManager $countManager)
    {
        $this->comments = $comments;
        $this->countManager = $countManager;
    }

    public function create(ForumReplyCreatorObserver $observer, $data, $threadId, $validator = null)
    {
        // check the passed in validator
        if ($validator && ! $validator->isValid()) {
            return $observer->forumReplyValidationError($validator->getErrors());
        }
        return $this->createValidRecord($observer, $data, $threadId);
    }

    private function createValidRecord($observer, $data, $threadId)
    {
        $reply = $this->comments->getNew($data + [
            'type'      => Comment::TYPE_FORUM,
            'parent_id' => $threadId,
        ]);

        // check the model validation
        if ( ! $this->comments->save($reply)) {
            return $observer->forumReplyValidationError($reply->getErrors());
        }

        // cache new thread update timestamps
        $this->countManager->cacheSections();

        return $observer->forumReplyCreated($reply);
    }
}