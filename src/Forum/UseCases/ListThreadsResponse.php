<?php namespace Lio\Forum\UseCases; 

class ListThreadsResponse
{
    public $threads;

    public function __construct($threads)
    {
        $this->threads = $threads;
    }
} 
