<?php

namespace App\Jobs;

use App\Http\Requests\ThreadRequest;
use App\Models\Thread;
use App\Models\Topic;
use App\User;

class CreateThread
{
    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $body;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var \App\User
     */
    private $author;

    /**
     * @var \App\Models\Topic
     */
    private $topic;

    /**
     * @var array
     */
    private $tags;

    public function __construct(string $subject, string $body, string $ip, User $author, Topic $topic, array $tags = [])
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->ip = $ip;
        $this->author = $author;
        $this->topic = $topic;
        $this->tags = $tags;
    }

    public static function fromRequest(ThreadRequest $request): self
    {
        return new static(
            $request->subject(),
            $request->body(),
            $request->ip(),
            $request->author(),
            $request->topic(),
            $request->tags()
        );
    }

    public function handle(): Thread
    {
        $thread = new Thread([
            'subject' => $this->subject,
            'body' => $this->body,
            'ip' => $this->ip,
            'slug' => $this->subject,
        ]);
        $thread->authoredBy($this->author);
        $thread->setTopic($this->topic);
        $thread->syncTags($this->tags);
        $thread->save();

        return $thread;
    }
}
