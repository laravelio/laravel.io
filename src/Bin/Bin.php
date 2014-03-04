<?php namespace Lio\Bin;

use Lio\Core\EventGenerator;
use Lio\Bin\Events\PasteCreatedEvent;

class Bin
{
    use EventGenerator;

    public function createPaste($code, $author)
    {
        $paste = new Paste(['code' => $code, 'author' => $author]);
        $this->raise(new PasteCreatedEvent($paste));
        return $paste;
    }
}