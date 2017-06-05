<?php

namespace spec\App\Spam;

use App\Spam\SpamFilter;
use App\Spam\SpamDetector;
use PhpSpec\ObjectBehavior;
use App\Spam\DummySpamDetector;

class SpamFilterSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(SpamFilter::class);
        $this->shouldHaveType(SpamDetector::class);
    }

    public function it_can_detect_spam()
    {
        $this->beConstructedWith(DummySpamDetector::withSpam());

        $this->detectsSpam('some spam')->shouldReturn(true);
    }

    public function it_passes_when_no_spam_was_detected()
    {
        $this->beConstructedWith(DummySpamDetector::withoutSpam());

        $this->detectsSpam('No spam here!')->shouldReturn(false);
    }
}
