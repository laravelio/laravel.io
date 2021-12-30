<?php

namespace App\Enums;

enum ReplyPolicyAction: string
{
    case CREATE = 'create';
    case UPDATE = 'update';
    case DELETE = 'delete';
}
