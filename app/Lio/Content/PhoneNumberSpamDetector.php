<?php
namespace Lio\Content;

class PhoneNumberSpamDetector implements SpamDetector
{
    /** @inheritdoc */
    public function detectsSpam($value)
    {
        return (bool) preg_match('/\+(?:\d{1,2})?[\s-+]*?(?:\d{10,})/', $value);
    }
}
