<?php namespace Controllers;

class Home extends Base
{
	public function getIndex()
	{
		return $this->view('home.index');
	}
}