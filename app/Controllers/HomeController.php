<?php namespace Controllers;

class HomeController extends BaseController
{
	public function getIndex()
	{
		return $this->view('home.index');
	}
}