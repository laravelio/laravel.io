<?php

namespace App\Http\Requests;

use App\Forum\ThreadData;
use App\Models\Topic;
use App\User;
use App\Validation\DoesNotContainUrlRule;
use Auth;

class ThreadRequest extends Request implements ThreadData
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        return [
            'topic' => 'required|exists:topics,id',
            'subject' => 'required|'.DoesNotContainUrlRule::NAME.'|spam',
            'body' => 'required|spam',
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

    public function topic(): Topic
    {
        return Topic::find((int) $this->get('topic'));
    }

    public function tags(): array
    {
        return $this->get('tags');
    }

    public function changed(): array
    {
        return array_merge($this->only('subject', 'body', 'tags'), ['topic' => $this->topic()]);
    }
}
