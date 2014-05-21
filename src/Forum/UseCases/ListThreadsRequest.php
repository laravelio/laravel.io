<?php namespace Lio\Forum\UseCases; 

class ListThreadsRequest
{
    public $tags;
    public $page;
    public $status;
    public $threadsPerPage;

    public function __construct($tags, $status, $page, $threadsPerPage)
    {
        $this->tags = $tags;
        $this->page = $page;
        $this->status = $status;
        $this->threadsPerPage = $threadsPerPage;
    }
} 
