<?php
namespace Lio\Content;

class ForeignLanguageSpamDetector implements SpamDetector
{
    /** @inheritdoc */
    public function detectsSpam($value)
    {
        return (bool) preg_match("/[일안명빠에외전나밤】]+/iu", $value);
    }
}
