<?php

class DashboardController extends BaseController
{
    public function getIndex()
    {
        $user = Auth::user();
        $user->load(['forumThreads', 'forumReplies']);
        $this->view('dashboard.index', ['user' => $user]);
    }
}
