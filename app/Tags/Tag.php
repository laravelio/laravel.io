<?php

namespace App\Tags;

interface Tag
{
    public function id(): int;
    public function name(): string;
    public function slug(): string;
    public function description(): string;

    /**
     * @return \App\Forum\Thread[]
     */
    public function threads();
}
