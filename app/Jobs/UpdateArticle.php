<?php

namespace App\Jobs;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use Illuminate\Support\Arr;

final class UpdateArticle
{
    private $article;

    private $attributes;

    public function __construct(Article $article, array $attributes = [])
    {
        $this->article = $article;
        $this->attributes = Arr::only($attributes, ['title', 'body', 'slug', 'tags']);
    }

    public static function fromRequest(Article $article, ArticleRequest $request): self
    {
        return new static($article, [
            'title' => $request->title(),
            'body' => $request->body(),
            'slug' => $request->title(),
            'tags' => $request->tags(),
        ]);
    }

    public function handle(): Article
    {
        $this->article->update($this->attributes);

        if (Arr::has($this->attributes, 'tags')) {
            $this->article->syncTags($this->attributes['tags']);
        }

        $this->article->save();

        return $this->article;
    }
}
