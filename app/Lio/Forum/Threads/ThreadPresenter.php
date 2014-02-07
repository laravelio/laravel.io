<?php namespace Lio\Forum\Threads;

use McCool\LaravelAutoPresenter\BasePresenter;
use App, Input, Str, Request;

class ThreadPresenter extends BasePresenter
{
    public function url()
    {
        if ( ! $this->slug) {
            return '';
        }
        return action('ForumThreadsController@getShowThread', [$this->slug]);
    }

    public function reply_count_label()
    {
        if ($this->resource->reply_count == 0) {
            return '0 Responses';
        } elseif($this->resource->reply_count == 1) {
            return '1 Response';
        }

        return $this->resource->reply_count . ' Responses';
    }

    public function created_ago()
    {
        return $this->resource->created_at->diffForHumans();
    }

    public function updated_ago()
    {
        return $this->resource->updated_at->diffForHumans();
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
        if ($this->resource->laravel_version == 3) {
            return '[L3] ';
        }
    }

    public function subject()
    {
        return "{$this->versionSubjectPrefix()}{$this->resource->subject}";
    }

    public function LatestReplyMeta()
    {
        if($this->resource->replies->count() > 0) {
            return "latest reply {$this->updated_ago} by {$this->resource->lastReply()->author->name}";
        }
    }

    public function latestReplyUrl()
    {
        // Check if the thread has replies, if it does return a direct link to the latest reply
        if($this->resource->replies->count() > 0) {
            return $this->url . \App::make('Lio\Forum\Replies\ReplyQueryStringGenerator')->generate($this->lastReply());
        } else {
            // Thread does not have any replies, return thread url.
            return $this->url;
        }
    }

    public function acceptedSolutionUrl()
    {
        if($this->acceptedSolution()) {
            return $this->url . \App::make('Lio\Forum\Replies\ReplyQueryStringGenerator')->generate($this->acceptedSolution());
        }
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

    private function removeDoubleSpaces($content)
    {
        return str_replace('  ', '', $content);
    }

    private function convertNewlines($content)
    {
        return preg_replace("/(?<!\\n)(\\n)(?!\\n)/", "<br>", $content);
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
        $linkify = new \Misd\Linkify\Linkify();
        return $linkify->process($content);
    }
}
