<?php

namespace App\Models;

use App\Helpers\HasAuthor;
use App\Helpers\HasTimestamps;
use App\Http\Requests\ReplyRequest;
use App\User;
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

    public function replyAble()
    {
        return $this->replyAbleRelation;
    }

    public function replyAbleRelation(): MorphTo
    {
        return $this->morphTo('replyable');
    }

    public static function createFromRequest(ReplyRequest $request): Reply
    {
        $reply = new static();
        $reply->body = $request->body();
        $reply->author_id = $request->author()->id();
        $reply->ip = $request->ip();

        $request->replyAble()->repliesRelation()->save($reply);

        $reply->save();

        return $reply;
    }

    public static function deleteByAuthor(User $author)
    {
        static::where('author_id', $author->id())->delete();
    }
}
