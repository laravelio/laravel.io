<?php namespace Lio\Articles;

use McCool\LaravelAutoPresenter\BasePresenter;
use \Michelf\MarkdownExtra;
use App, Str;

class ArticlePresenter extends BasePresenter
{
    public function content()
    {
        $content = $this->resource->content;
        $content = $this->convertMarkdown($content);
        $content = $this->convertNewlines($content);
        $content = $this->formatGists($content);
        $content = $this->linkify($content);
        return $content;
    }

    public function comment_count_label()
    {
        if ($this->resource->comment_count == 0) {
            return '0 Comments';
        } elseif($this->resource->comment_count == 1) {
            return '1 Comment';
        }

        return $this->resource->comment_count . ' Comments';
    }

    public function excerpt()
    {
        // kinda a mess but s'ok for now
        $html = App::make('Lio\Markdown\HtmlMarkdownConvertor')->convertMarkdownToHtml($this->resource->content);
        $text = strip_tags($html);
        if (false !== strpos($text, "\n\n")) {
            list($excerpt, $dump) = explode("\n\n", $text);
        } else {
            $excerpt = $text;
        }
        return Str::words($excerpt, 200);
    }

    public function published_at()
    {
        return $this->resource->published_at->toFormattedDateString();
    }

    public function published_ago()
    {
        return $this->resource->published_at->diffForHumans();
    }

    public function updateUrl()
    {
        return action('Controllers\Articles\UpdateArticleController@getUpdate', [$this->id]);
    }

    public function deleteUrl()
    {
        return action('Controllers\Articles\DeleteArticleController@getDelete', [$this->id]);
    }

    public function showUrl()
    {
        return action('Controllers\Articles\ShowArticleController@getShow', [$this->slug]);
    }

    // ------------------- //

    private function convertMarkdown($content)
    {
        return App::make('Lio\Markdown\HtmlMarkdownConvertor')->convertMarkdownToHtml($content);
    }

    private function convertNewlines($content)
    {
        return nl2br($content);
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
