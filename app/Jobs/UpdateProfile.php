<?php

namespace App\Jobs;

use App\Http\Requests\UpdateProfileRequest;
use App\User;

class UpdateProfile
{
    /**
     * @var \App\User
     */
    public $user;

    /**
     * @var \App\Http\Requests\UpdateProfileRequest
     */
    private $request;

    public function __construct(User $user, UpdateProfileRequest $request)
    {
        $this->user = $user;
        $this->request = $request;
    }

    public function handle()
    {
        $this->user->name = $this->request->name();
        $this->user->email = $this->request->email();
        $this->user->username = $this->request->username();
        $this->user->save();
    }
}
