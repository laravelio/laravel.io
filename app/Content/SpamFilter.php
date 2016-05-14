<?php
namespace Lio\Content;

use Lio\Accounts\User;

class SpamFilter implements SpamDetector
{
    /**
     * @var \Lio\Content\SpamDetector[]
     */
    private $detectors;

    /**
     * @param \Lio\Content\SpamDetector[] $detectors
     */
    public function __construct(array $detectors)
    {
        $this->detectors = $detectors;
    }

    /** @inheritdoc */
    public function detectsSpam($value, User $user = null)
    {
        return collect($this->detectors)
            ->contains(function ($key, SpamDetector $detector) use ($value, $user) {
                return $detector->detectsSpam($value, $user);
            });
    }
}
