<?php namespace Lio\Comments;

use Lio\Core\Entity;
use Str;

class Comment extends Entity
{
    protected $table      = 'comments';
    protected $fillable   = ['title', 'body', 'author_id', 'parent_id', 'category_slug', 'owner_id', 'owner_type', 'type', 'laravel_version'];
    protected $with       = ['author'];
    protected $softDelete = true;

    public $presenter = 'Lio\Comments\CommentPresenter';

    protected $validatorRules = [
        'body'      => 'required',
        'author_id' => 'required|exists:users,id',
    ];

    protected $laravelVersions = [
        0 => "Doesn't Matter",
        3 => "Laravel 3.x",
        4 => "Laravel 4.x",
    ];

    const TYPE_FORUM   = 0;
    const TYPE_PASTE   = 1;
    const TYPE_ARTICLE = 2;

    public function owner()
    {
        return $this->morphTo('owner');
    }

    public function author()
    {
        return $this->belongsTo('Lio\Accounts\User', 'author_id');
    }

    public function parent()
    {
        return $this->belongsTo('Lio\Comments\Comment', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('Lio\Comments\Comment', 'parent_id');
    }

    public function tags()
    {
        return $this->belongsToMany('Lio\Tags\Tag', 'comment_tag', 'comment_id', 'tag_id');
    }

    public function mostRecentChild()
    {
        return $this->belongsTo('Lio\Comments\Comment', 'most_recent_child_id');
    }

    public function setBodyAttribute($content)
    {
        //$body = \App::make('Lio\Markdown\HtmlMarkdownConvertor')->convertHtmlToMarkdown($content);
        $this->attributes['body'] = $content;
    }

    public function getLaravelVersions()
    {
        return $this->laravelVersions;
    }

    public function isOwnedBy(\Lio\Accounts\User $user)
    {
        return $user->id == $thread->author_id;
    }

    public function setMostRecentChild(Comment $comment)
    {
        $this->most_recent_child_id = $comment->id;
        $this->updateChildCount();
        $this->save();
    }

    public function updateChildCount()
    {
        if ($this->exists) {
            $this->child_count = $this->children()->count();
            $this->save();
        }
    }

    public function hasTag($tagId)
    {
        return $this->tags->contains($tagId);
    }

    public function isMainComment()
    {
        if(! $this->parent_id) return true;
    }

    public function getSlugString()
    {
        if ($this->type == static::TYPE_FORUM && is_null($this->parent_id)) {
            return $this->getForumPostSlugString();
        }
    }

    //
    protected function getForumPostSlugString()
    {
        if (empty($this->title)) return '';
        $date = date("m-d-Y", strtotime($this->created_at));
        return Str::slug("{$date} - {$this->title}");
    }

    //
    public function delete()
    {
        if ($this->exists && $this->isMainComment()) {
            $this->children()->delete();
        }
        parent::delete();
    }

    public function isNewerThan($timestamp)
    {
        return strtotime($this->updated_at) > $timestamp;
    }
}