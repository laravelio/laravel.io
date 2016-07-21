<?php

namespace Lio\Forum;

use Lio\Forum\Topics\Topic;
use Lio\Forum\Topics\TopicRepository;
use Lio\Http\Requests\Request;

class ThreadRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'topic' => 'required|exists:topics,id',
            'subject' => 'required',
            'body' => 'required',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
        ];
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
