<?php namespace Lio\BladeParsing;

class BladeParser
{
    protected $tags = [];

    public function parse($view)
    {
        foreach ($this->tags as $tag) {
            if ($tag->getMatchCount($view) > 0) $view = $tag->transform($view);
        }

        return $view;
    }

    public function addTag(BladeTag $tag)
    {
        $this->tags[] = $tag;
    }
}