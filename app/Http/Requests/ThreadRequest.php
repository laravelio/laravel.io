<?php

namespace App\Http\Requests;

use App\Forum\ThreadData;
use App\Forum\Topic;
use App\Forum\TopicRepository;
use App\Users\User;
use Auth;

class ThreadRequest extends Request implements ThreadData
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        $rules = [
            'topic' => 'required|exists:topics,id',
            'subject' => 'required|not_contain_url|spam',
            'body' => 'required|spam',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
        ];

        if (! app()->runningUnitTests()) {
            $rules['g-recaptcha-response'] = 'required|recaptcha';
        }

        return $rules;
    }

    public function dataForUpdate(): array
    {
        return array_merge($this->only('subject', 'body', 'tags'), ['topic' => $this->topic()]);
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
        return app(TopicRepository::class)->find((int) $this->get('topic'));
    }

    public function tags(): array
    {
        return $this->get('tags');
    }
}
