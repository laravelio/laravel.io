<?php namespace Controllers;

use Controller, View, Redirect;

class Base extends Controller
{
    protected $layout = 'layouts.default';

    protected function setupLayout()
    {
        if ( ! is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }

    protected function view($path, $data = [])
    {
        $this->layout->content = View::make($path, $data);
    }

    protected function redirectAction($action, $data = [])
    {
        return Redirect::action($action, $data);
    }

    protected function redirectRoute($route, $data = [])
    {
        return Redirect::route($route, $data);
    }

    protected function redirectBack($data = [])
    {
        return Redirect::back()->withInput()->with($data);
    }

    protected function redirectIntended($defaultAction = null)
    {
        return Redirect::intended($defaultAction);
    }
}