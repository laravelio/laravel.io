<?php

class Syndication
{
	public static function rss2()
	{

        if(Cache::has('rss_feed'))
        {
            $feed_xml = Cache::get('rss_feed');
        }
        else
        {

            require_once __DIR__.'/vendor/FeedWriter.php';
            require_once __DIR__.'/vendor/FeedItem.php';

            $feed = new FeedWriter(RSS2); 

            $feed->setTitle(Config::get('syndication::syndication.feed_title'));
            $feed->setLink(Config::get('syndication::syndication.feed_link'));
            $feed->setDescription(Config::get('syndication::syndication.feed_description'));

            $feed_data_closure = Config::get('syndication::syndication.feed_data');

            $feed_data = $feed_data_closure();

            if($feed_data)
            {
                foreach($feed_data as $index => $feed_row)
                {
                    if($index == 0)
                    {
                        $feed->setChannelElement('updated', date(DATE_ATOM , strtotime($feed_row['date'])));
                    }

                    $new_item = $feed->createNewItem();

                    $new_item->setTitle($feed_row['title']);
                    $new_item->setLink($feed_row['link']);
                    $new_item->setDate(strtotime($feed_row['date']));
                    $new_item->setDescription(Sparkdown\Markdown(strip_tags($feed_row['description'])));

                    $feed->addItem($new_item);
                }                
            }

            ob_start();

            $feed->genarateFeed();
            $feed_xml = ob_get_contents();

            ob_end_clean();

            Cache::put('rss_feed', $feed_xml, 900);
        }

        return $feed_xml;
	}
}