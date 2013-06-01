<?php

class Base_Controller extends Controller
{
	public $restful = true;
	public $layout  = 'layouts.default';

	public function before()
	{
		$this->layout->sidebar = View::make('layouts._sidebar');
	}

	public function __call($method, $parameters)
	{
		return Response::error('404');
	}
}