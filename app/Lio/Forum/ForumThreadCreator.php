<?php namespace Lio\Forum;

use Lio\Comments\CommentRepository;
use Lio\Comments\Comment;
use Lio\Forum\ForumSectionCountManager;

/**
* This class can call the following methods on the observer object:
*
* forumThreadValidationError($errors)
* forumThreadCreated($thread)
*/
class ForumThreadCreator
{
    protected $comments;
    protected $countManager;

    public function __construct(CommentRepository $comments, ForumSectionCountManager $countManager)
    {
        $this->comments = $comments;
        $this->countManager = $countManager;
    }

    public function create(ForumThreadCreatorObserver $observer, $data, $validator = null)
    {
        // check the passed in validator
        if ($validator && ! $validator->isValid()) {
            return $observer->forumThreadValidationError($validator->getErrors());
        }
        return $this->createValidRecord($observer, $data);
    }

    private function createValidRecord($observer, $data)
    {
        $thread = $this->comments->getNew($data + [
            'type' => Comment::TYPE_FORUM,
        ]);

        // check the model validation
        if ( ! $this->comments->save($thread)) {
            return $observer->forumThreadValidationError($thread->getErrors());
        }

        if (isset($data['tags'])) {
            $this->attachTags($thread, $data['tags']);
        }

        // cache new thread update timestamps
        $this->countManager->cacheSections();

        return $observer->forumThreadCreated($thread);
    }

    private function attachTags($thread, $tags)
    {
        $thread->tags()->sync($tags->lists('id'));
    }
}