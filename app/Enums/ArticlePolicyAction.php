<?php

namespace App\Enums;

enum ArticlePolicyAction: string
{
    case UPDATE = 'update';
    case DELETE = 'delete';
    case APPROVE = 'approve';
    case DISAPPROVE = 'disapprove';
    case DECLINE = 'decline';
    case PINNED = 'togglePinnedStatus';
}
