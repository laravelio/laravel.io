<?php namespace Lio\Articles;

use Lio\Core\Entity;

class Article extends Entity
{
    protected $table      = 'articles';
    protected $with       = ['author'];
    protected $fillable   = ['author_id', 'title', 'content', 'laravel_version', 'published_at'];
    protected $dates      = ['published_at'];
    protected $softDelete = true;

    public $presenter = 'Lio\Articles\ArticlePresenter';

    const STATUS_DRAFT     = 0;
    const STATUS_PUBLISHED = 1;


    protected $validationRules = [
        'author_id' => 'required|exists:users,id',
        'title'     => 'required',
        'content'   => 'required',
        'status'    => 'in:0,1',
    ];

    public function author()
    {
        return $this->belongsTo('Lio\Accounts\User', 'author_id');
    }

    public function tags()
    {
        return $this->belongsToMany('Lio\Tags\Tag', 'article_tag', 'article_id', 'tag_id');
    }

    public function comments()
    {
        return $this->morphMany('Lio\Comments\Comment', 'owner');
    }

    public function updateCommentCount()
    {
        $this->comment_count = $this->comments()->count();
        $this->save();
    }

    public function setTags(array $tagIds)
    {
        $this->tags()->sync($tagIds);
    }

    public function hasTag($id)
    {
        return $this->tags->contains($id);
    }

    public function isManageableBy($user)
    {
        if ( ! $user) return false;
        return $this->isOwnedBy($user) || $user->isArticleAdmin();
    }

    public function isOwnedBy($user)
    {
        if ( ! $user) return false;
        return $user->id == $this->author_id;
    }

    public function isPublished()
    {
        return $this->exists && $this->status == static::STATUS_PUBLISHED;
    }

    public function hasBeenPublished()
    {
        return ! is_null($this->published_at);
    }

    public function createSlug()
    {
        $authorName = $this->author->name;
        $date       = date("m-d-Y", strtotime($this->published_at));
        $title      = $this->title;

        return \Str::slug("{$authorName} {$date} {$title}");
    }

    public function setDraft()
    {
        if ($this->exists && $this->isPublished()) {
            $this->status = static::STATUS_DRAFT;
        }
        $this->save();
    }

    public function publish()
    {
        if ($this->exists && ! $this->isPublished()) {
            $this->status = static::STATUS_PUBLISHED;
            $this->slug = $this->createSlug();

            if ( ! $this->hasBeenPublished()) {
                $this->published_at = date('Y-m-d H:i:s');
            }

            $this->save();
        }
    }

    public function save(array $options = array())
    {
        if($this->status == static::STATUS_PUBLISHED && ! $this->published_at) {
            $this->published_at = $this->freshTimestamp();
        }

        return parent::save($options);
    }
}
