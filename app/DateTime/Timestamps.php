<?php

namespace Lio\DateTime;

use Carbon\Carbon;

interface Timestamps
{
    public function createdAt(): Carbon;
    public function updatedAt(): Carbon;
}
