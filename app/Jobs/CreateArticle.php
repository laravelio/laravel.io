<?php

namespace App\Jobs;

use App\Events\ArticleWasCreated;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Models\User;

final class CreateArticle
{
    private $title;

    private $body;

    private $author;

    private $shouldBeSubmitted;

    private $originalUrl;

    private $tags;

    public function __construct(string $title, string $body, User $author, bool $shouldBeSubmitted, array $options = [])
    {
        $this->title = $title;
        $this->body = $body;
        $this->author = $author;
        $this->shouldBeSubmitted = $shouldBeSubmitted;
        $this->originalUrl = $options['original_url'] ?? null;
        $this->tags = $options['tags'] ?? [];
    }

    public static function fromRequest(ArticleRequest $request): self
    {
        return new static(
            $request->title(),
            $request->body(),
            $request->author(),
            $request->shouldBeSubmitted(),
            [
                'original_url' => $request->originalUrl(),
                'tags' => $request->tags(),
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
            'submitted_at' => $this->shouldBeSubmitted ? now() : null,
        ]);
        $article->authoredBy($this->author);
        $article->syncTags($this->tags);

        event(new ArticleWasCreated($article));

        return $article;
    }
}
