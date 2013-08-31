<?php namespace Controllers;

class ContactThanks extends Base
{
    public function index()
    {
        return $this->view('contactthanks.index');
    }
}