<?php

return array(

    /*
	|--------------------------------------------------------------------------
	| Feed Title
	|--------------------------------------------------------------------------
	*/

    'feed_title' => 'Laravel IO',

    /*
	|--------------------------------------------------------------------------
	| Feed Link
	|--------------------------------------------------------------------------
	*/

    'feed_link' => 'http://laravel.io',

	/*
	|--------------------------------------------------------------------------
	| Feed Description
	|--------------------------------------------------------------------------
	*/

	'feed_description' => 'A study group targeted at learning more about the Laravel PHP MVC framework.',

	/*
	|--------------------------------------------------------------------------
	| Feed Cache Timeout in Minutes
	|--------------------------------------------------------------------------
	*/

	'feed_cache_timeout_minutes' => 900,

	'feed_data' => function()
	{
        $topics = Topic::recent(30);

        if(!$topics)
        {
            return false;
        }

        $feed_data = array();

        foreach($topics as $index => $topic)
        {
        	$feed_data[] = array(
        		'title' => $topic->title,
        		'link' => $topic->url,
        		'date' => $topic->created_at,
        		'description' => Sparkdown\Markdown(strip_tags($topic->body))
        	);
        }

        return $feed_data;
	}

);