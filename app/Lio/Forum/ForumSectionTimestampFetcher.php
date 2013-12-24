<?php namespace Lio\Forum;

use Lio\Comments\Comment;
use Lio\Tags\TagRepository;

class ForumSectionTimestampFetcher
{
    protected $model;
    protected $tags;

    public function __construct(Comment $model, TagRepository $tags)
    {
        $this->model = $model;
        $this->tags = $tags;
    }

    public function cacheSections($forumSections)
    {
        $cache = [];

        foreach ($forumSections as $section => $tags) {
            $cache[$tags] = $this->getMostRecentTimestamps($tags);
        }

        return $cache;
    }

    protected function getMostRecentTimestamps($tags)
    {
        $tags = $this->tags->getAllTagsBySlug($tags);
        $timestamps = $this->queryByTags($tags);
        if (empty($timestamps)) return [];
        return $this->formatTimestampArray($timestamps);
    }

    protected function queryByTags($tags)
    {
        $query = $this->model
            ->where('type', '=', COMMENT::TYPE_FORUM)
            ->join('comment_tag', 'comments.id', '=', 'comment_tag.comment_id');

        if (count($tags)) {
            $query->whereIn('comment_tag.tag_id', $tags->lists('id'));
        }

        $query->groupBy('comments.id')
            ->orderBy('comments.updated_at', 'desc')
            ->take(9);

        return $query->get(['comments.updated_at'])->toArray();
    }

    protected function formatTimestampArray($timestamps)
    {
        $formatted = [];

        foreach ($timestamps as $timestamp) {
            $formatted[] = strtotime($timestamp['updated_at']);
        }

        return $formatted;
    }
}