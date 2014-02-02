<?php namespace Lio\Github;

class GistEmbedFormatter
{
    protected $pattern = '/(https:\/\/gist.github.com\/\w+\/\w+)/';

    public function format($html)
    {
        return preg_replace($this->pattern, '<a href="$0">$0</a><script src="$0.js"></script>', $html);
    }
}
