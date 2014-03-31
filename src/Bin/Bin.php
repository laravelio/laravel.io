<?php namespace Lio\Bin;

use Lio\Bin\Events\ForkCreatedEvent;
use Lio\Core\EventGenerator;
use Lio\Bin\Events\PasteCreatedEvent;

class Bin
{
    use EventGenerator;

    public function addPaste($code, $author)
    {
        $paste = new Paste([
            'code' => $code,
            'author' => $author
        ]);
        $this->raise(new PasteCreatedEvent($paste));
        return $paste;
    }

    public function addFork(Paste $parent, $code, $author)
    {
        $fork = new Paste([
            'code' => $code,
            'author' => $author,
            'parent' => $parent
        ]);
        $this->raise(new ForkCreatedEvent($fork));
        return $fork;
    }
}
