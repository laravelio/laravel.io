<?php

use Lio\Accounts\UseCases\ViewProfileRequest;

class ProfileController extends BaseController
{
    public function getShow($name)
    {
        $request = new ViewProfileRequest($name);
        $response = $this->bus->execute($request);

        $this->render('users.profile', [
            'user' => $response->member,
            'threads' => $response->threads,
            'replies' => $response->replies,
        ]);
    }
}
