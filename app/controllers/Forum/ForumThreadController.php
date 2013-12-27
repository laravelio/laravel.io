<?php

use Lio\Comments\CommentRepository;
use Lio\Comments\Comment;

use Lio\Tags\TagRepository;

use Lio\Forum\ForumThreadForm;
use Lio\Forum\ForumThreadCreatorObserver;
use Lio\Forum\ForumThreadUpdaterObserver;
use Lio\Forum\ForumSectionCountManager;

class ForumThreadController extends BaseController implements ForumThreadCreatorObserver, ForumThreadUpdaterObserver
{
    protected $categories;
    protected $comments;
    protected $sections;

    protected $threadsPerPage = 20;
    protected $commentsPerPage = 20;

    public function __construct(CommentRepository $comments, TagRepository $tags, ForumSectionCountManager $sections)
    {
        $this->comments = $comments;
        $this->tags = $tags;
        $this->sections = $sections;

        $forumSections = Config::get('forum.sections');
        $sectionCounts = $this->sections->getCounts($forumSections, Session::get('forum_last_visited'));

        View::share(compact('forumSections', 'sectionCounts'));
    }





}