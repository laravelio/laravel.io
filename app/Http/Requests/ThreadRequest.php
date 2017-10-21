<?php

namespace App\Http\Requests;

use App\User;
use App\Validation\SpamRule;
use App\Validation\DoesNotContainUrlRule;

class ThreadRequest extends Request
{
    public function rules()
    {
        return [
            'subject' => 'required|max:60|'.DoesNotContainUrlRule::NAME.'|'.SpamRule::NAME,
            'body' => 'required|'.SpamRule::NAME,
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
        ];
    }

    public function author(): User
    {
        return $this->user();
    }

    public function subject(): string
    {
        return $this->get('subject');
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
