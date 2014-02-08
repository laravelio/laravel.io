<?php namespace Lio\Forum\Replies;

/**
* This class can call the following methods on the observer object:
*
* replyCreationError($errors)
* replyCreated($reply)
*/
class ReplyCreator
{
    protected $replies;

    public function __construct(ReplyRepository $replies)
    {
        $this->replies = $replies;
    }

    public function create(ReplyCreatorListener $observer, $data, $threadId, $validator = null)
    {
        $this->runValidator($observer, $validator);
        $reply = $this->getNew($data, $threadId);
        return $this->validateAndSave($observer, $reply);
    }

    private function runValidator($observer, $validator)
    {
        if ($validator && ! $validator->isValid()) {
            return $observer->replyCreationError($validator->getErrors());
        }
    }

    private function getNew($data, $threadId)
    {
        return $this->replies->getNew($data + [
            'thread_id' => $threadId,
            'author_id' => $data['author']->id,
        ]);
    }

    private function validateAndSave($observer, $reply)
    {
        if ( ! $this->replies->save($reply)) {
            return $observer->replyCreationError($reply->getErrors());
        }

        $this->updateThreadCounts($reply->thread);

        return $observer->replyCreated($reply);
    }

    private function updateThreadCounts($thread)
    {
        $thread->updateReplyCount();
    }
}
