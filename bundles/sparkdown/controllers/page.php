<?php

/**
 * Sparkdown Page Controller
 * 
 * <code>
 *     Router::register('GET /(about)', 'sparkdown::page@show');
 * </code>
 * 
 * @category    Bundle
 * @package     Sparkdown
 * @author      Phill Sparks <me@phills.me.uk>
 * @license 	MIT License <http://www.opensource.org/licenses/mit>
 * @copyright   2012 Phill Sparks
 * 
 * @see  http://github.com/sparksp/laravel-markdown
 */
class Sparkdown_Page_Controller extends Controller {

	/**
	 * A simple action to show the given slug.
	 * 
	 * @param  string  $name  The file name of the markdown view to show
	 * @return Sparkdown\View
	 */
	public function action_show($name)
	{
		return Sparkdown\View::make($name);
	}

}
