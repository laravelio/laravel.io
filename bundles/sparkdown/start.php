<?php

// Map the Markdown classes
Autoloader::map(array(
	'Sparkdown\\View' => __DIR__.DS.'view'.EXT,
	'Sparkdown_Page_Controller' => __DIR__.DS.'controllers'.DS.'page'.EXT,
));

// It's safe to assume that if you've started the bundle you're
// going to want to use the parser.
require __DIR__.DS."parser.php";
