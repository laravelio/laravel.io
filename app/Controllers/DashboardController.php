<?php namespace Controllers;

class DashboardController extends BaseController
{
    public function getIndex()
    {
        $this->view('dashboard.index');
    }
}