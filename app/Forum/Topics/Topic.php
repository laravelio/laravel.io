<?php

namespace Lio\Forum\Topics;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Lio\DateTime\Timestamps;

interface Topic extends Timestamps
{
    public function id(): int;
    public function name(): string;
    public function slug(): string;

    /**
     * @return \Lio\Forum\Threads[]
     */
    public function threads();
    public function paginatedThreads(int $perPage = 10): LengthAwarePaginator;
}
