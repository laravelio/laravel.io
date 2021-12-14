<?php

namespace App\Jobs;

use App\Events\ArticleWasSubmittedForApproval;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Models\User;

final class CreateArticle
{
    private $originalUrl;

    private $tags;

    public function __construct(
        private string $title,
        private string $body,
        private User $author,
        private bool $shouldBeSubmitted,
        array $options = []
    ) {
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

        if ($article->isAwaitingApproval()) {
            event(new ArticleWasSubmittedForApproval($article));
        }

        return $article;
    }
}
