<?php

namespace App\Models;

use App\Exceptions\CouldNotMarkReplyAsSolution;
use App\Helpers\HasSlug;
use App\Helpers\HasAuthor;
use App\Helpers\HasTimestamps;
use App\Helpers\ModelHelpers;
use App\Helpers\ReceivesReplies;
use App\Helpers\HasTags;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Thread extends Model implements ReplyAble
{
    use HasAuthor, HasSlug, HasTimestamps, ModelHelpers, ReceivesReplies, HasTags;

    const TABLE = 'threads';

    /**
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * @var array
     */
    protected $fillable = ['subject', 'body', 'ip', 'slug'];

    public function id(): int
    {
        return $this->id;
    }

    public function subject(): string
    {
        return $this->subject;
    }

    public function body(): string
    {
        return $this->body;
    }

    public function excerpt(int $limit = 100): string
    {
        return str_limit(strip_tags(md_to_html($this->body())), $limit);
    }

    public function solutionReply(): ?Reply
    {
        return $this->solutionReplyRelation;
    }

    public function solutionReplyRelation(): BelongsTo
    {
        return $this->belongsTo(Reply::class, 'solution_reply_id');
    }

    public function isSolutionReply(Reply $reply): bool
    {
        if ($solution = $this->solutionReply()) {
            return $solution->id() === $reply->id();
        }

        return false;
    }

    public function markSolution(Reply $reply)
    {
        $thread = $reply->replyAble();

        if (! $thread instanceof Thread) {
            throw CouldNotMarkReplyAsSolution::replyAbleIsNotAThread($reply);
        }

        $this->solutionReplyRelation()->associate($reply);
        $this->save();
    }

    public function unmarkSolution()
    {
        $this->solutionReplyRelation()->dissociate();
        $this->save();
    }

    public function delete()
    {
        $this->removeTags();
        $this->removeReplies();

        parent::delete();
    }
}
