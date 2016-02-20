<?php
namespace Lio\Content;

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
