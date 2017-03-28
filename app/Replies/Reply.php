<?php

namespace App\Replies;

use App\Helpers\HasAuthor;
use App\Helpers\HasTimestamps;
use App\Users\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Reply extends Model
{
    use HasAuthor, HasTimestamps;

    /**
     * @var string
     */
    protected $table = 'replies';

    /**
     * @var array
     */
    protected $fillable = ['body'];

    public function id(): int
    {
        return $this->id;
    }

    public function body(): string
    {
        return $this->body;
    }

    public function replyAble(): ReplyAble
    {
        return $this->replyAbleRelation;
    }

    public function replyAbleRelation(): MorphTo
    {
        return $this->morphTo('replyable');
    }

    public static function createFromData(ReplyData $data): Reply
    {
        $reply = new static();
        $reply->body = $data->body();
        $reply->author_id = $data->author()->id();
        $reply->ip = $data->ip();

        $data->replyAble()->repliesRelation()->save($reply);

        $reply->save();

        return $reply;
    }

    public static function deleteByAuthor(User $author)
    {
        static::where('author_id', $author->id())->delete();
    }
}
