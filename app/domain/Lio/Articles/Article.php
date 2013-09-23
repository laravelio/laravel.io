<?php namespace Lio\Articles;

use McCool\LaravelSlugs\SlugInterface;
use Lio\Core\EloquentBaseModel;

class Article extends EloquentBaseModel implements SlugInterface
{
    protected $table    = 'articles';
    protected $with     = ['author'];
    protected $fillable = ['author_id', 'title', 'content', 'status', 'published_at'];
    protected $dates    = ['published_at'];

    public $presenter = 'Lio\Articles\ArticlePresenter';

    const STATUS_DRAFT     = 0;
    const STATUS_PUBLISHED = 1;


    protected $validationRules = [
        'author_id' => 'required|exists:users,id',
        'title'     => 'required',
        'content'   => 'required',
        'status'    => 'required',
    ];

    public function author()
    {
        return $this->belongsTo('Lio\Accounts\User', 'author_id');
    }

    public function tags()
    {
        return $this->belongsToMany('Lio\Tags\Tag', 'article_tag', 'article_id', 'tag_id');
    }

    public function setTagsAttribute($tagIds)
    {
        $tagRepository = \App::make('\Lio\Tags\TagRepository');
        $allTagIds = $tagRepository->getTagIdList();

        $tagsToSync = [];

        foreach ($tagIds as $tagId) {
            if (in_array($tagId, $allTagIds)) {
                $tagsToSync[] = $tagId;
            }
        }

        if (empty($tagsToSync)) return;

        $this->tags()->sync($tagsToSync);
    }

    public function hasTag($tagId)
    {
        return $this->tags->contains($tagId);
    }

    public function isPublished()
    {
        if ($this->exists and $this->status == static::STATUS_PUBLISHED) {
            return true;
        }

        return false;
    }

    // SlugInterface
    public function slug()
    {
        return $this->morphOne('McCool\LaravelSlugs\Slug', 'owner');
    }

    public function getSlugString()
    {
        if ( ! $this->status == static::STATUS_PUBLISHED) {
            return '';
        }

        $authorName = $this->author->name;
        $date       = date("m-d-Y", strtotime($this->published_at));
        $title      = $this->title;

        return \Str::slug("{$date} {$title} {$authorName}");
    }
}