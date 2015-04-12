<?php
namespace Lio\Forum\Threads;

use Illuminate\Support\MessageBag;
use Lio\Accounts\User;
use Lio\Content\SpamDetector;
use Psr\Log\LoggerInterface;

class ThreadCreator
{
    /**
     * @var \Lio\Forum\Threads\ThreadRepository
     */
    private $threads;

    /**
     * @var \Lio\Content\SpamDetector
     */
    private $spamDetector;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @param \Lio\Forum\Threads\ThreadRepository $threads
     * @param \Lio\Content\SpamDetector $spamDetector
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(ThreadRepository $threads, SpamDetector $spamDetector, LoggerInterface $logger)
    {
        $this->threads = $threads;
        $this->spamDetector = $spamDetector;
        $this->logger = $logger;
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
        if ($this->spamDetector->detectsSpam($thread->subject)) {
            $this->logSpam($thread->subject, $thread->author);

            $this->increaseUserSpamCount($thread->author);

            return $listener->threadCreationError(
                new MessageBag(['subject' => 'Title contains spam. Your account has been flagged.'])
            );
        }

        if ($this->spamDetector->detectsSpam($thread->body)) {
            $this->logSpam($thread->body, $thread->author);

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

    /**
     * @param string $spam
     * @param \Lio\Accounts\User $author
     */
    private function logSpam($spam, User $author)
    {
        $this->logger->warning("Warning: attempted spam posted by [#{$author->id}] {$author->name}:");
        $this->logger->warning($spam);
    }
}
