<?php

namespace App\Forum;

use App\Users\User;

interface NewThread
{
    public function author(): User;
    public function subject(): string;
    public function body(): string;
    public function topic(): Topic;
    public function ip();
    public function tags(): array;
}
