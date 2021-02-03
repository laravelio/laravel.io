<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EmailAddressWasChanged
{
    use Dispatchable;
    use SerializesModels;

    /**
     * @var \App\Models\User
     */
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
