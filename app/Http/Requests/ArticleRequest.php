<?php

namespace App\Http\Requests;

use App\Rules\AuthorOwnsSeriesRule;
use App\Rules\HttpImageRule;
use App\User;

class ArticleRequest extends Request
{
    public function rules()
    {
        return [
            'title' => ['required', 'max:100'],
            'body' => ['required', new HttpImageRule],
            'tags' => 'array|nullable',
            'tags.*' => 'exists:tags,id',
            'original_url' => 'url|nullable',
            'series' => ['nullable', new AuthorOwnsSeriesRule],
            'status' => ['required', 'in:draft,publish'],
        ];
    }

    public function author(): User
    {
        return $this->user();
    }

    public function title(): string
    {
        return $this->get('title');
    }

    public function body(): string
    {
        return $this->get('body');
    }

    public function tags(): array
    {
        return $this->get('tags', []);
    }

    public function series(): ?string
    {
        return $this->get('series');
    }

    public function originalUrl(): ?string
    {
        return $this->get('original_url');
    }

    public function shouldBePublished(): bool
    {
        return $this->get('status') === 'publish';
    }
}
