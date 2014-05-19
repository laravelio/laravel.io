<?php namespace Lio\Forum\UseCases; 

class ListThreadsRequest
{
    public $tags;
    public $page;
    public $status;
    public $perPage;

    public function __construct($tags, $page, $status, $perPage)
    {
        $this->tags = $tags;
        $this->page = $page;
        $this->status = $status;
        $this->perPage = $perPage;
    }
} 
