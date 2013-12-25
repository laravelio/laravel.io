<?php namespace Lio\Forum;

use Lio\Accounts\User;

class ForumSectionUpdateCountCalculator
{
    protected $forumSections;
    protected $visitedTimestamps;
    protected $postTimestamps;

    public function __construct($forumSections, $visitedTimestamps, $postTimestamps)
    {
        $this->forumSections = $forumSections;
        $this->visitedTimestamps = $visitedTimestamps;
        $this->postTimestamps = $postTimestamps;
    }

    public function getCounts()
    {
        $counts = [];

        foreach ($this->forumSections as $title => $tags) {
            $counts[$tags] = $this->getNewCount($tags);
        }

        return $counts;
    }

    protected function getNewCount($tags)
    {
        if ( ! isset($this->visitedTimestamps[$tags])) {
            return count($this->postTimestamps[$tags]);
        }
        return $this->countNewPosts($tags);
    }

    protected function countNewPosts($tags)
    {
        $visited = $this->visitedTimestamps[$tags];

        if ( ! isset($this->postTimestamps[$tags])) {
            return 0;
        }

        $new = array_filter($this->postTimestamps[$tags], function($posted) use ($visited) {
            return $visited < $posted;
        });

        return count($new);
    }
}