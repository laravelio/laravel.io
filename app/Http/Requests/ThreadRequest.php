<?php

namespace App\Http\Requests;

use App\Forum\Topic;
use App\Forum\TopicRepository;
use Auth;

class ThreadRequest extends Request
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

    public function topic(): Topic
    {
        return app(TopicRepository::class)->find((int) $this->get('topic'));
    }

    public function dataForStore(): array
    {
        return array_merge($this->only('tags'), ['ip' => $this->ip()]);
    }

    public function dataForUpdate(): array
    {
        return array_merge($this->only('subject', 'body', 'tags'), ['topic' => $this->topic()]);
    }
}
