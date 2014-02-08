<?php namespace Lio\Forum\Threads;

use Lio\Forum\Replies\ReplyQueryStringGenerator;
use McCool\LaravelAutoPresenter\BasePresenter;
use App, Input, Str, Request;

class ThreadPresenter extends BasePresenter
{
    public function __construct($resource)
    {
        parent::__construct($resource);

        $this->replyGenerator = new ReplyQueryStringGenerator;
    }

    public function url()
    {
        if ( ! $this->slug) {
            return '';
        }
        return action('ForumThreadsController@getShowThread', [$this->slug]);
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
        $body = $this->resource->body;
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
        return "{$this->versionSubjectPrefix()}{$this->resource->subject}";
    }

    public function mostRecentReplier()
    {
        if ( ! $this->mostRecentReply) {
            return null;
        }
        return $this->mostRecentReply->author->name;
    }

    public function latestReplyUrl()
    {
        if ( ! $this->mostRecentReply) {
            return $this->url;
        }
        return $this->url . $this->replyGenerator->generate($this->mostRecentReply);
    }

    public function acceptedSolutionUrl()
    {
        if ( ! $this->acceptedSolution) {
            return null;
        }

        return $this->url . $this->replyGenerator->generate($this->acceptedSolution);
    }

    public function editUrl()
    {
        return action('ForumThreadsController@getEditThread', [$this->id]);
    }

    public function deleteUrl()
    {
        return action('ForumThreadsController@getDelete', [$this->id]);
    }

    public function markAsSolutionUrl($replyId)
    {
        return action('ForumThreadsController@getMarkQuestionSolved', [$this->resource->id, $replyId]);
    }

    public function markAsUnsolvedUrl()
    {
        return action('ForumThreadsController@getMarkQuestionUnsolved', [$this->resource->id]);
    }

    // ------------------- //

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
        $linkify = new \Misd\Linkify\Linkify();
        return $linkify->process($content);
    }
}
