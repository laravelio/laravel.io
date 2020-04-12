<?php

namespace App\Http\Requests;

use App\Rules\HttpImageRule;
use App\User;

class ArticleRequest extends Request
{
    public function rules()
    {
        return [
            'title' => ['required', 'max:100'],
            'body' => ['required', new HttpImageRule],
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
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
}
