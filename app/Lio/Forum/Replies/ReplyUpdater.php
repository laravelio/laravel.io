<?php namespace Lio\Forum\Replies;

/**
* This class can call the following methods on the observer object:
*
* replyUpdateError($errors)
* replyUpdated($reply)
*/
class ReplyUpdater
{
    protected $replies;

    public function __construct(ReplyRepository $replies)
    {
        $this->replies = $replies;
    }

    public function update($reply, ReplyUpdaterListener $observer, $data, $validator = null)
    {
        // check the passed in validator
        if ($validator && ! $validator->isValid()) {
            return $observer->replyUpdateError($validator->getErrors());
        }
        return $this->updateRecord($reply, $observer, $data);
    }

    private function updateRecord($reply, $observer, $data)
    {
        $reply->fill($data);

        // check the model validation
        if ( ! $this->replies->save($reply)) {
            return $observer->replyUpdateError($reply->getErrors());
        }

        return $observer->replyUpdated($reply);
    }
}
