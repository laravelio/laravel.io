<?php namespace Lio\Articles\Entities;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Lio\Accounts\Member;
use Lio\Events\EventGenerator;
use Lio\Tags\Taggable;

class Article extends Model
{
    use Taggable, EventGenerator;

    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    private $placedComment;

    protected $table      = 'articles';
    protected $with       = ['author'];
    protected $guarded    = [];
    protected $dates      = ['published_at'];
    protected $softDelete = true;

    public $presenter = 'Lio\Articles\ArticlePresenter';

    public function author()
    {
        return $this->belongsTo('Lio\Accounts\Member', 'author_id');
    }

    public function comments()
    {
        return $this->hasMany('Lio\Articles\Entities\Comment');
    }

    public static function compose(Member $author, $title, $content, $status, $laravelVersion, array $tagIds = [])
    {
        $article = new static([
            'author_id' => $author->id,
            'title' => $title,
            'content' => $content,
            'status' => $status,
            'laravel_version' => $laravelVersion,
        ]);
        $article->setTagsById($tagIds);
        return $article;
    }

    public function edit($title, $content, $laravelVersion, array $tagIds = [])
    {
        $this->title = $title;
        $this->content = $content;
        $this->laravelVersion = $laravelVersion;
        $this->setTagsById($tagIds);
    }

    public function publish()
    {
        $this->status = self::STATUS_PUBLISHED;
        if ( ! $this->slug) {
            $this->slug = $this->createSlugFromDetails();
        }
        if ( ! $this->published_at) {
            $this->published_at = new DateTime;
        }
    }

    private function createSlugFromDetails()
    {
        $date = (new DateTime)->format('m-d-Y');
        return Str::slug("{$this->author->name} {$date} {$this->title}");
    }

    public function unpublish()
    {
        $this->status = self::STATUS_DRAFT;
    }

    public function placeComment(Member $author, $content)
    {
        $comment = new Comment([
            'article_id' => $this->id,
            'author_id' => $author->id,
            'content' => $content
        ]);
        $this->placedComment = $comment;
        return $comment;
    }

    public function hasPlacedComment()
    {
        return ! is_null($this->placedComment);
    }

    public function getPlacedComment()
    {
        return $this->placedComment;
    }

//    public function setDraft()
//    {
//        if ($this->exists && $this->isPublished()) {
//            $this->status = static::STATUS_DRAFT;
//        }
//        $this->save();
//    }

//    public function updateCommentCount()
//    {
//        $this->comment_count = $this->comments()->count();
//        $this->save();
//    }
//
//    public function isManageableBy($user)
//    {
//        if ( ! $user) return false;
//        return $this->isOwnedBy($user) || $user->isArticleAdmin();
//    }

    public function isOwnedBy($user)
    {
        if ( ! $user) {
            return false;
        }
        return $user->id == $this->author_id;
    }

    public function isPublished()
    {
        return $this->status == static::STATUS_PUBLISHED;
    }

    public function hasBeenPublished()
    {
        return ! is_null($this->published_at);
    }
}
