<?php

class Irc_Controller extends Base_Controller
{
    // topic index page
    public function get_index()
    {
    	$this->layout->page_title = "Join the official #Laravel IRC Channel";
    	$this->layout->sidebar = "";
        $this->layout->content = View::make('irc.index');
    }
}