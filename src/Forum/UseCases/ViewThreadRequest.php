<?php namespace Lio\Forum\UseCases; 

class ViewThreadRequest
{
    public $slug;
    public $page;
    public $repliesPerPage;

    public function __construct($slug, $page, $repliesPerPage)
    {
        $this->slug = $slug;
        $this->page = $page;
        $this->repliesPerPage = $repliesPerPage;
    }
} 
