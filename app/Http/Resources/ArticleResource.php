<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Article
 */
class ArticleResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->getKey(),
            'url' => route('articles.show', $this->slug()),
            'title' => $this->title(),
            'body' => $this->body(),
            'original_url' => $this->originalUrl(),
            'author' => AuthorResource::make($this->author()),
            'tags' => TagResource::collection($this->tags()),
            'is_submitted' => $this->isSubmitted(),
            'submitted_at' => $this->submittedAt(),
            'created_at' => $this->createdAt(),
            'updated_at' => $this->updatedAt(),
        ];
    }
}
