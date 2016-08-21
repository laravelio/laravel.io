<?php

namespace App\Markdown;

interface Converter
{
    public function toHtml(string $markdown): string;
}
