<?php

namespace App\Enums;

enum ThreadPolicyAction: string
{
    case UPDATE = 'update';
    case DELETE = 'delete';
    case SUBSCRIBE = 'subscribe';
    case UNSUBSCRIBE = 'unsubscribe';
}
