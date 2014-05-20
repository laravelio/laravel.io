<?php namespace Lio\Bin\UseCases; 

use Lio\Bin\Entities\Paste;

class ViewPasteResponse
{
    /**
     * @var \Lio\Bin\Entities\Paste
     */
    private $paste;

    public function __construct(Paste $paste)
    {
        $this->paste = $paste;
    }
} 
