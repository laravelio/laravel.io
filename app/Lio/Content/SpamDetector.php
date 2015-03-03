<?php
namespace Lio\Content;

interface SpamDetector
{
    /**
     * @param mixed $value
     * @return bool
     */
    public function detectsSpam($value);
}
