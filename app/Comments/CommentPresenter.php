<?php
namespace Lio\Comments;

use Illuminate\Support\Str;
use McCool\LaravelAutoPresenter\BasePresenter;
use App, Input, Request;

class CommentPresenter extends BasePresenter
{
    public function forumThreadUrl()
    {
        $slug = $this->getWrappedObject()->slug;
        if ( ! $slug) return '';
        return action('Forum\ForumThreadsController@getShowThread', [$slug->slug]);
    }

    public function commentUrl()
    {
        $pagination = null;
        $slug = $this->getWrappedObject()->parent->slug;
        if ( ! $slug) return '';

        $url = action('Forum\ForumRepliesController@getCommentRedirect', [$slug->slug, $this->id]);
        return $url;
    }

    public function child_count_label()
    {
        if ($this->getWrappedObject()->child_count == 0) {
            return '0 Responses';
        } elseif($this->getWrappedObject()->child_count == 1) {
            return '1 Response';
        }

        return $this->getWrappedObject()->child_count . ' Responses';
    }

    public function created_ago()
    {
        return $this->getWrappedObject()->created_at->diffForHumans();
    }

    public function updated_ago()
    {
        return $this->getWrappedObject()->updated_at->diffForHumans();
    }

    public function body()
    {
        $body = $this->getWrappedObject()->body;
        $body = $this->convertMarkdown($body);
        $body = $this->convertNewlines($body);
        $body = $this->formatGists($body);
        $body = $this->linkify($body);
        return $body;
    }

    public function bodySummary()
    {
        $summary = Str::words($this->getWrappedObject()->body, 50);

        return App::make('Lio\Markdown\HtmlMarkdownConvertor')->convertMarkdownToHtml($summary);
    }

    public function laravel_version()
    {
        if ($this->getWrappedObject()->laravel_version == 3) {
            return '[L3]';
        }

        if ($this->getWrappedObject()->laravel_version == 4) {
            return '[L4]';
        }

        if ($this->getWrappedObject()->laravel_version == 5) {
            return '[L5]';
        }
    }

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
        return App::make('Lio\Github\GistEmbedFormatter')->format($content);
    }

    private function linkify($content)
    {
        $linkify = new \Misd\Linkify\Linkify();
        return $linkify->process($content);
    }
}
