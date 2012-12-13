<?php namespace Sparkdown;

// Note: much of this code is taken from \Laravel\View and will need maintaining as 
// the core View class is updated.

use Bundle, Event;

/**
 * Sparkdown View
 * 
 * Markdown view files are found in standard views directories; bundle syntax works too.
 * 
 * @category    Bundle
 * @package     Sparkdown
 * @author      Phill Sparks <me@phills.me.uk>
 * @license 	MIT License <http://www.opensource.org/licenses/mit>
 * @copyright   2012 Phill Sparks
 */
class View extends \Laravel\View {

	/**
	 * File extension for Markdown view files.
	 */
	const EXT = '.md';

	/**
	 * Get the path to a given view on disk.
	 *
	 * @param  string  $view
	 * @return string
	 */
	protected function path($view)
	{
		$view = str_replace('.', '/', $view);

		$root = Bundle::path(Bundle::name($view)).'views/';

		// Views may have the normal PHP extension or the Blade PHP extension, so
		// we need to check if either of them exist in the base views directory
		// for the bundle. We'll check for the PHP extension first since that
		// is probably the more common of the two.
		if (is_file($path = $root.Bundle::element($view).static::EXT))
		{
			return $path;
		}

		throw new \Exception("Markdown view [$view] does not exist.");
	}

	/**
	 * Get the evaluated string content of the view.
	 *
	 * @return string
	 */
	public function render()
	{
		// To allow bundles or other pieces of the application to modify the
		// view before it is rendered, we will fire an event, passing in the
		// view instance so it can modified by any of the listeners.
		Event::fire("composing: {$this->view}", array($this));

		$this->path = $this->compile();

		return file_get_contents($this->path);
	}


	/**
	 * Get the path to the compiled version of the Markdown view.
	 *
	 * @return string
	 */
	protected function compile()
	{
		// Compiled views are stored in the storage directory using the MD5
		// hash of their path. This allows us to easily store the views in
		// the directory without worrying about re-creating the entire
		// application view directory structure.
		$compiled = path('storage').'views/'.md5($this->path);

		// The view will only be re-compiled if the view has been modified
		// since the last compiled version of the view was created or no
		// compiled view exists. Otherwise, the path will be returned
		// without re-compiling the view.
		if ( ! is_file($compiled) or (filemtime($this->path) > filemtime($compiled)))
		{
			$text = file_get_contents($this->path);
            $html = Markdown($text);

            file_put_contents($compiled, $html);
		}

		return $compiled;
	}

}