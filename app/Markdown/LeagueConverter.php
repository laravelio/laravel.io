<?php

namespace App\Markdown;

use League\CommonMark\CommonMarkConverter;

final class LeagueConverter implements Converter
{
    public function __construct(
        private CommonMarkConverter $converter
    ) {
    }

    public function toHtml(string $markdown): string
    {
        return $this->converter->convertToHtml($markdown);
    }
}
