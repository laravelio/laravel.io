<?php namespace Controllers;

use Auth;

class DashboardController extends BaseController
{
    public function getIndex()
    {
        $this->view('dashboard.index', ['user' => Auth::user()]);
    }
}