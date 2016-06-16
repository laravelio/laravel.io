<?php

namespace Lio\Spam;

use Lio\Users\User;

class SpamFilter implements SpamDetector
{
    /**
     * @var \Lio\Spam\SpamDetector[]
     */
    private $detectors;

    /**
     * @param \Lio\Spam\SpamDetector[] $detectors
     */
    public function __construct(array $detectors)
    {
        $this->detectors = $detectors;
    }

    public function detectsSpam($value, User $user = null): bool
    {
        return collect($this->detectors)
            ->contains(function ($key, SpamDetector $detector) use ($value, $user) {
                return $detector->detectsSpam($value, $user);
            });
    }
}
