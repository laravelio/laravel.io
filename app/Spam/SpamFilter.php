<?php

namespace App\Spam;

use App\User;

class SpamFilter implements SpamDetector
{
    /**
     * @var \App\Spam\SpamDetector[]
     */
    private $detectors;

    public function __construct(SpamDetector ...$detectors)
    {
        $this->detectors = $detectors;
    }

    public function detectsSpam($value, User $user = null): bool
    {
        return collect($this->detectors)
            ->contains(function (SpamDetector $detector) use ($value, $user) {
                return $detector->detectsSpam($value, $user);
            });
    }
}
