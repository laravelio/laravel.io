<?php
namespace Lio\Spam;

interface SpamDetector
{
    /**
     * @param mixed $value
     * @return bool
     */
    public function detectsSpam($value);
}
