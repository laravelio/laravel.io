<?php namespace Lio\Forum\Threads;

use Illuminate\Support\MessageBag;
use Lio\Accounts\User;
use Lio\Validators\DoesNotContainPhoneNumbers;

/**
* This class can call the following methods on the listener object:
*
* threadCreationError($errors)
* threadCreated($thread)
*/
class ThreadCreator
{
    /**
     * @var \Lio\Forum\Threads\ThreadRepository
     */
    protected $threads;

    /**
     * @var \Lio\Validators\DoesNotContainPhoneNumbers
     */
    protected $phoneNumbers;

    /**
     * @param \Lio\Forum\Threads\ThreadRepository $threads
     * @param \Lio\Validators\DoesNotContainPhoneNumbers $phoneNumbers
     */
    public function __construct(ThreadRepository $threads, DoesNotContainPhoneNumbers $phoneNumbers)
    {
        $this->threads = $threads;
        $this->phoneNumbers = $phoneNumbers;
    }

    // an additional validator is optional and will be run first, an example of a usage for
    // this is a form validator
    public function create(ThreadCreatorListener $listener, $data, $validator = null)
    {
        if ($validator && ! $validator->isValid()) {
            return $listener->threadCreationError($validator->getErrors());
        }
        return $this->createValidRecord($listener, $data);
    }

    private function createValidRecord($listener, $data)
    {
        $thread = $this->getNew($data);

        return $this->validateAndSave($thread, $listener, $data);
    }

    private function getNew($data)
    {
        return $this->threads->getNew($data + [
            'author_id' => $data['author']->id,
        ]);
    }

    private function validateAndSave($thread, $listener, $data)
    {
        if ($this->containsSpam($thread->subject)) {
            $this->increaseUserSpamCount($thread->author);

            return $listener->threadCreationError(
                new MessageBag(['subject' => 'Title contains spam. Your account has been flagged.'])
            );
        }

        if ($this->containsSpam($thread->body)) {
            $this->increaseUserSpamCount($thread->author);

            return $listener->threadCreationError(
                new MessageBag(['body' => 'Body contains spam. Your account has been flagged.'])
            );
        }

        // check the model validation
        if (! $this->threads->save($thread)) {
            return $listener->threadCreationError($thread->getErrors());
        }

        // attach any tags that were passed through
        if (isset($data['tags'])) {
            $thread->setTags($data['tags']->lists('id'));
        }

        return $listener->threadCreated($thread);
    }

    /**
     * Determines if one or more subject contain spam
     *
     * @param string|array $subject
     * @return bool
     */
    private function containsSpam($subject)
    {
        if ($this->containsKoreanOrChinese($subject)) {
            return true;
        }

        // If the validator detects phone numbers, return false.
        return ! $this->phoneNumbers->validate($subject);
    }

    /**
     * @param string $subject
     * @return bool
     */
    private function containsKoreanOrChinese($subject)
    {
        return (bool) preg_match("/[\p{Hangul}|\p{Han}]+/u", $subject);
    }

    /**
     * Increases a user's spam count
     *
     * @param \Lio\Accounts\User $user
     */
    private function increaseUserSpamCount(User $user)
    {
        $user->spam_count = $user->spam_count + 1;

        // If the user reaches a spam threshold of 3 or more, automatically ban him
        if ($user->spam_count >= 3) {
            $user->is_banned = true;
        }

        $user->save();
    }
}
