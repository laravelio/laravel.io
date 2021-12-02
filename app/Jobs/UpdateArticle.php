<?php

namespace App\Jobs;

use App\Events\ArticleWasSubmittedForApproval;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;

final class UpdateArticle
{
    private $originalUrl;

    private $tags;

    public function __construct(
        private Article $article,
        private string $title,
        private string $body,
        private bool $shouldBeSubmitted,
        array $options = []
    ) {
        $this->originalUrl = $options['original_url'] ?? null;
        $this->tags = $options['tags'] ?? [];
    }

    public static function fromRequest(Article $article, ArticleRequest $request): self
    {
        return new static(
            $article,
            $request->title(),
            $request->body(),
            $request->shouldBeSubmitted(),
            [
                'original_url' => $request->originalUrl(),
                'tags' => $request->tags(),
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

        if ($this->shouldUpdateSubmittedAt()) {
            $this->article->submitted_at = now();
            $this->article->save();

            event(new ArticleWasSubmittedForApproval($this->article));
        }

        $this->article->syncTags($this->tags);

        return $this->article;
    }

    private function shouldUpdateSubmittedAt(): bool
    {
        return $this->shouldBeSubmitted && $this->article->isNotSubmitted();
    }
}
