<?php
namespace Lio\Forum\Replies;

use Input;
use McCool\LaravelAutoPresenter\BasePresenter;
use Misd\Linkify\Linkify;
use Request;

class ReplyPresenter extends BasePresenter
{
    public function url()
    {
        $slug = $this->getWrappedObject()->thread->slug;
        $threadUrl = action('Forum\ForumThreadsController@getShowThread', $slug);

        return $threadUrl . app(ReplyQueryStringGenerator::class)->generate($this->getWrappedObject());
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
        $body = $this->formatGists($body);
        $body = $this->linkify($body);

        return $body;
    }

    private function convertMarkdown($content)
    {
        return app('Lio\Markdown\HtmlMarkdownConvertor')->convertMarkdownToHtml($content);
    }

    private function formatGists($content)
    {
        return app('Lio\Github\GistEmbedFormatter')->format($content);
    }

    private function linkify($content)
    {
        $linkify = new Linkify();

        return $linkify->process($content);
    }
}
