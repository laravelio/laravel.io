<?php
namespace Lio\Http\Controllers;

class ChatController extends Controller
{
    public function getIndex()
    {
        $this->title = 'Live Chat';

        return view('chat.index');
    }
}
