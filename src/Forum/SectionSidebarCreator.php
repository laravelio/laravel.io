<?php namespace Lio\Forum;

use Config;

class SectionSidebarCreator
{
    public function __construct()
    {
        $this->sections = Config::get('forum.sections');
    }

    public function createSidebar($selectedSection = null)
    {
        if(! is_array($selectedSection)) {
            $selectedSection = explode(',', $selectedSection);
        }

        foreach($this->sections as $title => $attributes) {
            if($this->isCurrentSection($attributes['tags'], $selectedSection)) {
                $this->setCurrentSection($title);
            }
        }

        return $this->sections;
    }

    protected function isCurrentSection($sectionTags, $selectedSection)
    {
        $sectionTags = explode(',', $sectionTags);
        foreach($sectionTags as $sectionTag) {
            if(in_array(strtolower($sectionTag), array_map('strtolower', $selectedSection))) {
                return true;
            }
        }
    }

    protected function setCurrentSection($section)
    {
        $this->sections[$section]['active'] = true;
    }
}
