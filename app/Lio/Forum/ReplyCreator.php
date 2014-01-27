<?php namespace Lio\Forum;

use Lio\Forum\SectionCountManager;
use Lio\Comments\CommentRepository;
use Lio\Comments\Comment;

/**
* This class can call the following methods on the observer object:
*
* replyValidationError($errors)
* replyCreated($reply)
*/
class ReplyCreator
{
    protected $comments;
    protected $countManager;

    public function __construct(CommentRepository $comments, SectionCountManager $countManager)
    {
        $this->comments = $comments;
        $this->countManager = $countManager;
    }

    public function create(ReplyCreatorObserver $observer, $data, $threadId, $validator = null)
    {
        $this->runValidator($observer, $validator);
        $reply = $this->getNew($data);
        return $this->validateAndSave($reply);
    }

    private function runValidator($observer, $validator)
    {
        if ($validator && ! $validator->isValid()) {
            return $observer->replyValidationError($validator->getErrors());
        }
    }

    private function getNew($data)
    {
        return $this->comments->getNew($data + [
            'type'      => Comment::TYPE_FORUM,
            'parent_id' => $threadId,
        ]);
    }

    private function validateAndSave($observer, $reply)
    {
        if ( ! $this->comments->save($reply)) {
            return $observer->replyValidationError($reply->getErrors());
        }

        // cache new thread update timestamps
        $this->countManager->cacheSections();

        return $observer->replyCreated($reply);
    }
}