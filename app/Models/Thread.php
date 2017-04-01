<?php

namespace App\Models;

use App\Exceptions\CouldNotMarkReplyAsSolution;
use App\Helpers\HasSlug;
use App\Helpers\HasAuthor;
use App\Helpers\HasTimestamps;
use App\Helpers\ModelHelpers;
use App\Helpers\UsesReplies;
use App\Helpers\UsesTags;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Thread extends Model
{
    use HasAuthor, HasSlug, HasTimestamps, ModelHelpers, UsesReplies, UsesTags;

    const TABLE = 'threads';

    /**
     * @var string
     */
    protected $table = self::TABLE;

    /**
     * @var array
     */
    protected $fillable = ['subject', 'body'];

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

    public function slug(): string
    {
        return $this->slug;
    }

    public function topic(): Topic
    {
        return $this->topicRelation;
    }

    public function topicRelation(): BelongsTo
    {
        return $this->belongsTo(Topic::class, 'topic_id');
    }

    /**
     * @return \App\Models\Reply|null
     */
    public function solutionReply()
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
}
