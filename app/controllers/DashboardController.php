<?php

class DashboardController extends BaseController
{
    public function getIndex()
    {
        $user = Auth::user();
        $user->load('forumPosts');
        $this->view('dashboard.index', ['user' => $user]);
    }
}