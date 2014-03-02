<?php namespace Lio\Bin\Commands;

class CreatePasteCommand
{
    public $code;
    public $user;

    public function __construct($code, $user)
    {
        $this->code = $code;
        $this->user = $user;
    }
}