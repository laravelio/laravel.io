<?php

/*
|--------------------------------------------------------------------------
| Bundle Configuration
|--------------------------------------------------------------------------
*/

return array(
    'cacheable'           => array('auto' => true),
	'eloquent-base-model' => array('auto' => true),
	'sparkdown'           => array('auto' => true),
	'presenter'           => array('auto' => true),
	'gravitas'            => array('auto' => true),
    // @todo - cache comments for search bots
	//'disqus'              => array('auto' => true),
    'syndication',
);