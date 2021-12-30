<?php

namespace App\Enums;

enum UserPolicyAction: string
{
    case ADMIN = 'admin';
    case BAN = 'ban';
    case DELETE = 'delete';
}
