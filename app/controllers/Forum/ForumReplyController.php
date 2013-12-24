 <?php

use Lio\Comments\CommentRepository;
use Lio\Comments\Comment;
use Lio\Tags\TagRepository;
use Lio\Forum\ForumReplyForm;
use Lio\Forum\ForumReplyCreatorObserver;
use Lio\Forum\ForumReplyUpdaterObserver;
use Lio\Forum\ForumSectionCountManager;

class ForumReplyController extends BaseController implements ForumReplyCreatorObserver, ForumReplyUpdaterObserver
{
    protected $categories;
    protected $comments;

    public function __construct(CommentRepository $comments, TagRepository $tags, ForumSectionCountManager $sections)
    {
        $this->comments = $comments;
        $this->tags = $tags;
        $this->sections = $sections;

        $forumSections = Config::get('forum.sections');
        $sectionCounts = $this->sections->getCounts($forumSections, Session::get('forum_last_visited'));

        View::share(compact('forumSections', 'sectionCounts'));
    }

    public function store()
    {
        return App::make('Lio\Forum\ForumReplyCreator')->create($this, [
            'body'      => Input::get('body'),
            'author_id' => Auth::user()->id,
            'type'      => Comment::TYPE_FORUM,
            'thread'    => App::make('slugModel'),
        ], new ForumReplyForm);
    }

    public function edit($replyId)
    {
        $reply = $this->comments->requireForumThreadById($replyId);
        if (Auth::user()->id != $reply->author_id) return Redirect::to('/');
        $this->view('forum.editcomment', compact('reply'));
    }

    public function update($replyId)
    {
        $reply = $this->comments->requireForumThreadById($replyId);
        if (Auth::user()->id != $reply->author_id) return Redirect::to('/');

        return App::make('Lio\Forum\ForumReplyUpdater')->update($reply, $this, [
            'body' => Input::get('body'),
        ], new ForumReplyForm);
    }

    // observer methods
    public function forumReplyValidationError($errors)
    {
        return $this->redirectBack(['errors' => $errors]);
    }

    public function forumReplyCreated($reply)
    {
        // update cache for sidebar counts
        $this->sections->cacheSections(Config::get('forum.sections'));
        // awful demeter chain - clean up
        return $this->redirectAction('ForumThreadController@show', [$reply->parent()->first()->slug->slug]);
    }

    public function forumReplyUpdated($reply)
    {
        return $this->redirectAction('ForumThreadController@show', [$reply->parent->slug->slug]);
    }
}