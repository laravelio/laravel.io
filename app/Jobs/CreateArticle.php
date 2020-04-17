<?php

namespace App\Jobs;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Models\Series;
use App\User;

final class CreateArticle
{
    private $title;

    private $body;

    private $author;

    private $canonicalUrl;

    private $tags;

    private $series;

    public function __construct(string $title, string $body, User $author, string $canonicalUrl = null, array $tags = [], string $series = null)
    {
        $this->title = $title;
        $this->body = $body;
        $this->author = $author;
        $this->canonicalUrl = $canonicalUrl;
        $this->tags = $tags;
        $this->series = $series;
    }

    public static function fromRequest(ArticleRequest $request): self
    {
        return new static(
            $request->title(),
            $request->body(),
            $request->author(),
            $request->canonicalUrl(),
            $request->tags(),
            $request->series()
        );
    }

    public function handle(): Article
    {
        $article = new Article([
            'title' => $this->title,
            'body' => $this->body,
            'canonical_url' => $this->canonicalUrl,
            'slug' => $this->title,
        ]);
        $article->authoredBy($this->author);
        $article->syncTags($this->tags);
        $article->updateSeries(Series::find($this->series));
        $article->save();

        return $article;
    }
}
