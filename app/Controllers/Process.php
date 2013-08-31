<?php namespace Controllers;

class Process extends Base
{
    public function getIndex()
    {
        return $this->view('process.index');
    }
}