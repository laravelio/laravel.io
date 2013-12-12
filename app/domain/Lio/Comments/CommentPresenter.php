<?php namespace Lio\Comments;

use McCool\LaravelAutoPresenter\BasePresenter;
use App, Input, Str, Request;

class CommentPresenter extends BasePresenter
{
    public function forumThreadUrl()
    {
        $slug = $this->resource->slug;
        if ( ! $slug) return '';
        return action('ForumController@getThread', [$slug->slug]);
    }

    public function commentUrl()
    {
        $pagination = null;
        $slug = $this->resource->parent->slug;
        if ( ! $slug) return '';

        $url = action('ForumController@getComment', [$slug->slug, $this->id]);
        return $url;
    }

    public function child_count_label()
    {
        if ($this->resource->child_count == 0) {
            return '0 Responses';
        } elseif($this->resource->child_count == 1) {
            return '1 Response';
        }

        return $this->resource->child_count . ' Responses';
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
        $body = $this->convertNewlines($body);
        $body = $this->formatGists($body);
        return $body;
    }

    public function bodySummary()
    {
        $summary = Str::words($this->resource->body, 50);
        return App::make('Lio\Markdown\HtmlMarkdownConvertor')->convertMarkdownToHtml($summary);
    }

    // ------------------- //

    private function convertMarkdown($content)
    {
        return App::make('Lio\Markdown\HtmlMarkdownConvertor')->convertMarkdownToHtml($content);
    }

    private function convertNewlines($content)
    {
        return str_replace("\n\n", '<br/>', $content);
    }

    private function formatGists($content)
    {
        return App::make('Lio\GitHub\GistEmbedFormatter')->format($content);
    }
}