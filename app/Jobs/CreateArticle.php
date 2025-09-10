<?php

namespace App\Jobs;

use App\Events\ArticleWasSubmittedForApproval;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Models\User;
use Ramsey\Uuid\UuidInterface;

final class CreateArticle
{
    private $originalUrl;

    private $tags;

    public function __construct(
        private UuidInterface $uuid,
        private string $title,
        private string $body,
        private User $author,
        private bool $shouldBeSubmitted,
        private ?string $heroImageId = null,
        array $options = []
    ) {
        $this->originalUrl = $options['original_url'] ?? null;
        $this->tags = $options['tags'] ?? [];
    }

    public static function fromRequest(ArticleRequest $request, UuidInterface $uuid): self
    {
        return new self(
            $uuid,
            $request->title(),
            $request->body(),
            $request->author(),
            $request->shouldBeSubmitted(),
            $request->heroImageId(),
            [
                'original_url' => $request->originalUrl(),
                'tags' => $request->tags(),
            ],
        );
    }

    public function handle(): void
    {
        $article = new Article([
            'uuid' => $this->uuid->toString(),
            'title' => $this->title,
            'hero_image_id' => $this->heroImageId,
            'body' => $this->body,
            'original_url' => $this->originalUrl,
            'slug' => $this->title,
            'submitted_at' => $this->shouldBeSubmitted ? now() : null,
            'approved_at' => $this->canBeAutoApproved() ? now() : null,
        ]);
        $article->authoredBy($this->author);
        $article->syncTags($this->tags);

        if ($article->hero_image_id) {
            SyncArticleImage::dispatch($article);
        }

        if ($article->isAwaitingApproval()) {
            event(new ArticleWasSubmittedForApproval($article));
        }
    }

    private function canBeAutoApproved(): bool
    {
        return $this->shouldBeSubmitted && $this->author->canVerifiedAuthorPublishMoreArticlesToday();
    }
}
