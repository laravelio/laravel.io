<?php

namespace App\Markdown;

use League\CommonMark\CommonMarkConverter;

final class LeagueConverter implements Converter
{
    private CommonMarkConverter $converter;

    public function __construct(CommonMarkConverter $converter)
    {
        $this->converter = $converter;
    }

    public function toHtml(string $markdown): string
    {
        return $this->converter->convertToHtml($markdown);
    }
}
