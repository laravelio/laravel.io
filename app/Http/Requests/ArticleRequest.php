<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\HttpImageRule;
use Illuminate\Http\Concerns\InteractsWithInput;
use Illuminate\Validation\Rules\RequiredIf;

class ArticleRequest extends Request
{
    use InteractsWithInput;

    public function rules(): array
    {
        return [
            'title' => ['required', 'max:100'],
            'hero_image_id' => ['nullable', new RequiredIf(auth()->user()->isVerifiedAuthor())],
            'body' => ['required', new HttpImageRule],
            'tags' => 'array|nullable',
            'tags.*' => 'exists:tags,id',
            'original_url' => 'url|nullable',
            'submitted' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.max' => 'The :attribute must not be greater than :max characters.',
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

    public function heroImageId(): ?string
    {
        return $this->get('hero_image_id');
    }
}
