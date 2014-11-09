<?php namespace Lio\Articles;

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Lio\Core\Entity;
use McCool\LaravelAutoPresenter\PresenterInterface;

class Article extends Entity implements PresenterInterface
{
    use SoftDeletingTrait;

    protected $table    = 'articles';
    protected $with     = ['author'];
    protected $fillable = ['author_id', 'title', 'content', 'status', 'laravel_version', 'published_at'];
    protected $dates    = ['published_at', 'deleted_at'];

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

    public function comments()
    {
        return $this->morphMany('Lio\Comments\Comment', 'owner');
    }

    public function updateCommentCount()
    {
        $this->comment_count = $this->comments()->count();
        $this->save();
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
        return $this->exists && $this->status == static::STATUS_PUBLISHED);
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

    public function save(array $options = array())
    {
        if ($this->status == static::STATUS_PUBLISHED && ! $this->published_at) {
            $this->published_at = $this->freshTimestamp();
        }

        return parent::save($options);
    }

    /**
     * Get the presenter class.
     *
     * @return string The class path to the presenter.
     */
    public function getPresenter()
    {
        return 'Lio\Articles\ArticlePresenter';
    }
}
