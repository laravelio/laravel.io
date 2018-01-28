<?php

namespace App\Jobs;

use App\User;
use Illuminate\Contracts\Hashing\Hasher;

final class UpdatePassword
{
    /**
     * @var \App\User
     */
    private $user;

    /**
     * @var string
     */
    private $newPassword;

    public function __construct(User $user, string $newPassword)
    {
        $this->user = $user;
        $this->newPassword = $newPassword;
    }

    public function handle(Hasher $hasher)
    {
        $this->user->update(['password' => $hasher->make($this->newPassword)]);
    }
}
