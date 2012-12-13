<?php

class Base_Controller extends Controller
{
	public $restful = true;
	public $layout  = 'layouts.default';

	public function __call($method, $parameters)
	{
		return Response::error('404');
	}
}