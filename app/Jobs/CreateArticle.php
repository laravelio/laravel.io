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

    private $originalUrl;

    private $tags;

    private $series;

    public function __construct(string $title, string $body, User $author, array $options = [])
    {
        $this->title = $title;
        $this->body = $body;
        $this->author = $author;
        $this->originalUrl = $options['original_url'] ?? null;
        $this->tags = $options['tags'] ?? [];
        $this->series = $options['series'] ?? null;
    }

    public static function fromRequest(ArticleRequest $request): self
    {
        return new static(
            $request->title(),
            $request->body(),
            $request->author(),
            [
                'original_url' => $request->originalUrl(),
                'tags' => $request->tags(),
                'series' => $request->series(),
            ]
        );
    }

    public function handle(): Article
    {
        $article = new Article([
            'title' => $this->title,
            'body' => $this->body,
            'original_url' => $this->originalUrl,
            'slug' => $this->title,
        ]);
        $article->authoredBy($this->author);
        $article->syncTags($this->tags);
        $article->updateSeries(Series::find($this->series));
        $article->save();

        return $article;
    }
}
