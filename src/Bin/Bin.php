<?php namespace Lio\Bin;

use Lio\Core\EventGenerator;
use Lio\Bin\Events\PasteCreatedEvent;

class Bin
{
    use EventGenerator;

    public function createPaste($code, $user)
    {
        $paste = new Paste(['code' => $code, 'user' => $user]);
        $this->raise(new PasteCreatedEvent($paste));
        return $paste;
    }
}