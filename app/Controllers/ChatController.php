<?php namespace Controllers;

class ChatController extends BaseController
{
    private $categories;
    private $comments;

    public function getIndex()
    {
        $this->view('chat.index');
    }
}