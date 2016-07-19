<?php

namespace Lio\Markdown;

interface Converter
{
    public function toHtml(string $markdown): string;
}
