<?php
namespace Lio\Spam;

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

    /** @inheritdoc */
    public function detectsSpam($value)
    {
        foreach ($this->detectors as $detector) {
            if ($detector->detectsSpam($value)) {
                return true;
            }
        }

        return false;
    }
}
