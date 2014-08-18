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

    public function create(ReplyCreatorListener $listener, $data, $threadId, $validator = null)
    {
        if ($validator && ! $validator->isValid()) {
            return $listener->replyCreationError($validator->getErrors());
        }

        $reply = $this->getNew($data, $threadId);

        return $this->validateAndSave($listener, $reply);
    }

    private function getNew($data, $threadId)
    {
        return $this->replies->getNew($data + [
            'thread_id' => $threadId,
            'author_id' => $data['author']->id,
        ]);
    }

    private function validateAndSave($listener, $reply)
    {
        if (! $this->replies->save($reply)) {
            return $listener->replyCreationError($reply->getErrors());
        }

        $this->updateThreadCounts($reply->thread);
        $this->setThreadMostRecentReply($reply);

        return $listener->replyCreated($reply);
    }

    private function updateThreadCounts($thread)
    {
        $thread->updateReplyCount();
    }

    private function setThreadMostRecentReply($reply)
    {
        $reply->thread->setMostRecentReply($reply);
    }
}
