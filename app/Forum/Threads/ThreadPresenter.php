<?php
namespace Lio\Forum\Threads;

use Illuminate\Support\Str;
use McCool\LaravelAutoPresenter\BasePresenter;
use App, Input, Request;
use Misd\Linkify\Linkify;

class ThreadPresenter extends BasePresenter
{
    public function url()
    {
        if ( ! $this->slug) {
            return '';
        }
        return action('Forum\ForumThreadsController@getShowThread', [$this->slug]);
    }

    public function created_ago()
    {
        return $this->created_at->diffForHumans();
    }

    public function updated_ago()
    {
        return $this->updated_at->diffForHumans();
    }

    public function body()
    {
        $body = $this->getWrappedObject()->body;
        $body = $this->convertMarkdown($body);
        $body = $this->formatGists($body);
        $body = $this->linkify($body);
        return $body;
    }

    public function versionSubjectPrefix()
    {
        if ($this->laravel_version == 3) {
            return '[L3] ';
        }
    }

    public function subject()
    {
        $prefix = $this->versionSubjectPrefix();
        $subject = Str::limit($this->getWrappedObject()->subject, 80);

        return $prefix ? $prefix .' '. $subject : $subject;
    }

    public function mostRecentReplier()
    {
        return $this->replies->last()->author;
    }

    public function latestReplyUrl()
    {
        if (! count($this->replies)) {
            return $this->url;
        }

        return $this->url . App::make('Lio\Forum\Replies\ReplyQueryStringGenerator')->generate($this->replies->last());
    }

    public function lastReplyDiff()
    {
        if (count($this->replies)) {
            return $this->replies->last()->created_at->diffForHumans();
        }

        return $this->updated_ago();
    }

    public function acceptedSolutionUrl()
    {
        if ( ! $this->acceptedSolution) {
            return null;
        }

        return action('Forum\ForumRepliesController@getReplyRedirect', [$this->getWrappedObject()->slug, $this->acceptedSolution->id]);
    }

    public function editUrl()
    {
        return action('Forum\ForumThreadsController@getEditThread', [$this->id]);
    }

    public function deleteUrl()
    {
        return action('Forum\ForumThreadsController@getDelete', [$this->id]);
    }

    public function markAsSolutionUrl($replyId)
    {
        return action('Forum\ForumThreadsController@getMarkQuestionSolved', [$this->getWrappedObject()->id, $replyId]);
    }

    public function markAsUnsolvedUrl()
    {
        return action('Forum\ForumThreadsController@getMarkQuestionUnsolved', $this->getWrappedObject()->id);
    }

    private function convertMarkdown($content)
    {
        return App::make('Lio\Markdown\HtmlMarkdownConvertor')->convertMarkdownToHtml($content);
    }

    private function formatGists($content)
    {
        return App::make('Lio\Github\GistEmbedFormatter')->format($content);
    }

    private function linkify($content)
    {
        $linkify = new Linkify();
        return $linkify->process($content);
    }
}
