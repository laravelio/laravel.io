<?php

namespace App\Services;

use App\Ai\Agents\ArticleReviewer;
use App\Jobs\DeclineArticle;
use App\Models\Article;
use Throwable;
use UnexpectedValueException;

final class ReviewArticle
{
    public function allowsManualReview(Article $article): bool
    {
        try {
            $examples = Article::withoutEagerLoads()
                ->published()
                ->where('is_sponsored', false)
                ->whereKeyNot($article->id())
                ->recent()
                ->limit(10)
                ->get(['title', 'body'])
                ->map(fn (Article $example) => [
                    'title' => $example->title(),
                    'excerpt' => $example->excerpt(1000),
                ]);

            $response = ArticleReviewer::make()->prompt(
                json_encode([
                    'title' => $article->title(),
                    'body' => $article->body(),
                    'published_examples' => $examples->all(),
                ], JSON_THROW_ON_ERROR),
                provider: config('lio.moderation.provider'),
                model: config('lio.moderation.model'),
                timeout: config('lio.moderation.timeout'),
            );

            $isSuitable = $response['is_suitable'] ?? null;

            if (! is_bool($isSuitable)) {
                throw new UnexpectedValueException('The article reviewer did not return a boolean verdict.');
            }
        } catch (Throwable $exception) {
            report($exception);

            // Leave the decision to the human reviewer if AI review is unavailable.
            return true;
        }

        if (! $isSuitable) {
            dispatch_sync(new DeclineArticle($article));
        }

        return $isSuitable;
    }
}
