<?php

class ChatController extends BaseController
{
    public function getIndex()
    {
        $this->view('chat.index');
    }
}
