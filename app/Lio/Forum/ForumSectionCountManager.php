<?php namespace Lio\Forum;

use App, Cache, Session;

class ForumSectionCountManager
{
    protected $fetcher;

    public function __construct(ForumSectionTimestampFetcher $fetcher)
    {
        $this->fetcher = $fetcher;
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

    public function getCounts($forumSections, $lastVisited)
    {
        $timestamps = Cache::rememberForever('forum_sidebar_timestamps', function() {
            return $this->cacheSections($forumSections);
        });
        $calculator = new ForumSectionUpdateCountCalculator($forumSections, $lastVisited, $timestamps);
        return $calculator->getCounts();
    }

    public function cacheSections($forumSections)
    {
        // update cache for sidebar counts
        $timestamps = $this->fetcher->cacheSections($forumSections);
        Cache::put('forum_sidebar_timestamps', $timestamps, 1440);
    }
}