<?php

namespace App\Jobs;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\User;

final class CreateArticle
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $body;

    /**
     * @var \App\User
     */
    private $author;

    /**
     * @var array
     */
    private $tags;

    public function __construct(string $title, string $body, User $author, array $tags = [])
    {
        $this->title = $title;
        $this->body = $body;
        $this->author = $author;
        $this->tags = $tags;
    }

    public static function fromRequest(ArticleRequest $request): self
    {
        return new static(
            $request->title(),
            $request->body(),
            $request->author(),
            $request->tags()
        );
    }

    public function handle(): Article
    {
        $article = new Article([
            'title' => $this->title,
            'body' => $this->body,
            'slug' => $this->title,
        ]);
        $article->authoredBy($this->author);
        $article->syncTags($this->tags);
        $article->save();

        return $article;
    }
}
