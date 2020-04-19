<?php

namespace App\Jobs;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Models\Series;

final class UpdateArticle
{
    private $article;

    private $title;

    private $body;

    private $originalUrl;

    private $tags;

    private $series;

    public function __construct(Article $article, string $title, string $body, array $options = [])
    {
        $this->article = $article;
        $this->title = $title;
        $this->body = $body;
        $this->originalUrl = $options['original_url'] ?? null;
        $this->tags = $options['tags'] ?? [];
        $this->series = $options['series'] ?? null;
    }

    public static function fromRequest(Article $article, ArticleRequest $request): self
    {
        return new static(
            $article,
            $request->title(),
            $request->body(),
            [
                'original_url' => $request->originalUrl(),
                'tags' => $request->tags(),
                'series' => $request->series(),
            ]
        );
    }

    public function handle(): Article
    {
        $this->article->update([
            'title' => $this->title,
            'body' => $this->body,
            'original_url' => $this->originalUrl,
            'slug' => $this->title,
        ]);
        $this->article->syncTags($this->tags);
        $this->article->updateSeries(Series::find($this->series));
        $this->article->save();

        return $this->article;
    }
}
