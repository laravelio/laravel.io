<?php

namespace App\Jobs;

use App\Models\Reply;
use App\Models\User;
use App\Services\ModerateForumContent;

final class UpdateReply
{
    public function __construct(private Reply $reply, private User $updatedBy, private string $body) {}

    public function handle(): void
    {
        if ($this->shouldModerate()) {
            app(ModerateForumContent::class)->check($this->updatedBy, $this->body);
        }

        $this->reply->body = $this->body;
        $this->reply->updatedByRelation()->associate($this->updatedBy);
        $this->reply->save();
    }

    private function shouldModerate(): bool
    {
        return $this->updatedBy->isRegularUser()
            && $this->reply->isAuthoredBy($this->updatedBy)
            && $this->body !== $this->reply->body();
    }
}
