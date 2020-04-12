<?php

namespace App\Http\Requests;

use App\User;

class SeriesRequest extends Request
{
    public function rules()
    {
        return [
            'title' => ['required', 'max:100'],
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

    public function tags(): array
    {
        return $this->get('tags', []);
    }
}
