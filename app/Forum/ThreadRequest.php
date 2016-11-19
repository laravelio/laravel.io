<?php

namespace App\Forum;

use App\Forum\Topics\Topic;
use App\Forum\Topics\TopicRepository;
use App\Http\Requests\Request;

class ThreadRequest extends Request
{
    public function authorize()
    {
        return true;
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
