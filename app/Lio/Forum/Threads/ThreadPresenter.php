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
       // $body = $this->removeDoubleSpaces($body);
        $body = $this->convertMarkdown($body);
      //  $body = $this->convertNewlines($body);
        $body = $this->formatGists($body);
        $body = $this->linkify($body);
        return $body;
    }

    public function laravel_version()
    {
        if ($this->resource->laravel_version == 3) {
            return '[L3]';
        }
        if ($this->resource->laravel_version == 4) {
            return '[L4]';
        }
    }

    public function subject()
    {
        return "{$this->laravel_version()} {$this->resource->subject}";
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