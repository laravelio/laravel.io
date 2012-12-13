<?php
/**
 *
 * Autoload the base presenter class and presenter collection class
 *
 */

Autoloader::map(array(
	'Presenter' => Bundle::path('presenter').'presenter.php',
	'PresenterCollection' => Bundle::path('presenter').'presentercollection.php',
));
