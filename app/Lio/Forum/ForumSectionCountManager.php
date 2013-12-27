<?php namespace Lio\Forum;

use App, Cache, Session;

class ForumSectionCountManager
{
    protected $fetcher;

    public function __construct(ForumSectionTimestampFetcher $fetcher, $sections)
    {
        $this->fetcher = $fetcher;
        $this->sections = $sections;
    }

    public function updatedAndGetLastVisited($tags)
    {
        $forumLastVisited = Session::get('forum_last_visited');

        if (is_array($forumLastVisited)) {
            $lastVisited = isset($forumLastVisited[$tags]) ? $forumLastVisited[$tags] : 0;
            $forumLastVisited[$tags] = strtotime('now');
        } else {
            $lastVisited = 0;
            $forumLastVisited = [$tags => strtotime('now')];
        }

        Session::put('forum_last_visited', $forumLastVisited);

        return $lastVisited;
    }

    public function getCounts($lastVisited)
    {
        $sections = $this->sections;
        $timestamps = Cache::rememberForever('forum_sidebar_timestamps', function() use ($sections) {
            return $this->cacheSections($sections);
        });
        $calculator = new ForumSectionUpdateCountCalculator($this->sections, $lastVisited, $timestamps);
        return $calculator->getCounts();
    }

    public function cacheSections()
    {
        // update cache for sidebar counts
        $timestamps = $this->fetcher->cacheSections($this->sections);
        Cache::put('forum_sidebar_timestamps', $timestamps, 1440);
    }
}