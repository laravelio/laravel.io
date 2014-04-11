<?php

class ChatController extends BaseController
{
    public function getIndex()
    {
        $this->title = 'Live Chat';
        $this->view('chat.index');
    }
}
