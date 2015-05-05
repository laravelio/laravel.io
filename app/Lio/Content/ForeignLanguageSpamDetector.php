<?php
namespace Lio\Content;

class ForeignLanguageSpamDetector implements SpamDetector
{
    /** @inheritdoc */
    public function detectsSpam($value)
    {
        return (bool) preg_match("/[일안명빠에외전나밤노카지소테크카지주소る테】]+/iu", $value);
    }
}
