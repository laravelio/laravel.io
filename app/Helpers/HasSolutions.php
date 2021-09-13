<?php

namespace App\Helpers;

use App\Models\Reply;
use App\Models\User;
use App\Exceptions\CouldNotMarkReplyAsSolution;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasSolutions
{
    public function solutionReply(): ?Reply
    {
        return $this->solutionReplyRelation;
    }

    public function solutionSelector(): ?User
    {
        return $this->solutionSelectorRelation;
    }

    public function solutionReplyRelation(): BelongsTo
    {
        return $this->belongsTo(Reply::class, 'solution_reply_id');
    }

    public function solutionSelectorRelation(): BelongsTo
    {
        return $this->belongsTo(User::class, 'solution_selector_id');
    }

    public function isSolved(): bool
    {
        return ! is_null($this->solution_reply_id);
    }

    public function isSolutionReply(Reply $reply): bool
    {
        if ($solution = $this->solutionReply()) {
            return $solution->is($reply);
        }

        return false;
    }

    public function isSolutionSelector(User $user): bool
    {
        if ($selector = $this->solutionSelector()) {
            return $selector->is($user);
        }

        return false;
    }

    public function markSolution(Reply $reply, User $user)
    {
        $thread = $reply->replyAble();

        if (! $thread instanceof self) {
            throw CouldNotMarkReplyAsSolution::replyAbleIsNotAThread($reply);
        }

        $this->update([
            'solution_selector_id' => $user->id()
        ]);
        $this->solutionReplyRelation()->associate($reply);
        $this->save();
    }

    public function unmarkSolution()
    {
        $this->update([
            'solution_selector_id' => null
        ]);

        $this->solutionReplyRelation()->dissociate();
        $this->save();
    }
}