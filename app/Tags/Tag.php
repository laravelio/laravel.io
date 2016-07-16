<?php

namespace Lio\Tags;

interface Tag
{
    public function id(): int;
    public function name(): string;
    public function slug(): string;
    public function description(): string;

    /**
     * @return \Lio\Forum\Thread[]
     */
    public function threads();
}
