<?php

namespace App\Users;

interface Authored
{
    public function author(): User;
    public function isAuthoredBy(User $user): bool;
}
