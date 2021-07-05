<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\HttpImageRule;
use Illuminate\Http\Concerns\InteractsWithInput;

class ArticleRequest extends Request
{
    use InteractsWithInput;

    public function rules()
    {
        return [
            'title' => ['required', 'max:100'],
            'body' => ['required', new HttpImageRule()],
            'tags' => 'array|nullable',
            'tags.*' => 'exists:tags,id',
            'original_url' => 'url|nullable',
            'submitted' => ['required', 'boolean'],
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

    public function originalUrl(): ?string
    {
        return $this->get('original_url');
    }

    public function shouldBeSubmitted(): bool
    {
        return $this->boolean('submitted');
    }
}
