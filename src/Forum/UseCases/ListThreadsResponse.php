<?php namespace Lio\Forum\UseCases; 

class ListThreadsResponse
{
    private $threads;

    public function __construct($threads)
    {
        $this->threads = $threads;
    }
} 
