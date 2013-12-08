<?php namespace Lio\BladeParsing;

class ForumNavLinkTag implements BladeTag
{
    protected $pattern = '/\{\{\s?navLink\([\'"](.*?)[\'"],\s?[\'"](.*?)[\'"]\)\s?\}\}/';

    public function getPattern()
    {
        return $this->pattern;
    }

    public function getMatchCount($view)
    {
        return count($this->getMatches($view));
    }

    public function transform($view)
    {
        return $this->processView($view);
    }

    private function processView($view)
    {
        $matches = $this->getMatches($view);
        if (empty($matches)) return $view;

        foreach($matches as $match) {
            list($tag, $viewName) = $match;
            $view = $this->replaceTag($view, $tag, $viewName);
        }

        return $view;
    }

    private function getMatches($view)
    {
        preg_match_all($this->pattern, $view, $matches, PREG_SET_ORDER);
        return $matches;
    }

    private function replaceTag($view, $tag, $viewName)
    {
        return str_replace($tag, '@include($currentSite->template->getView("' . $viewName . '"))', $view);
    }
}