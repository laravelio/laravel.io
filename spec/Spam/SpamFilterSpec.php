<?php

namespace spec\App\Spam;

use App\Spam\DummySpamDetector;
use App\Spam\SpamDetector;
use App\Spam\SpamFilter;
use PhpSpec\ObjectBehavior;

class SpamFilterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SpamFilter::class);
        $this->shouldHaveType(SpamDetector::class);
    }

    function it_can_detect_spam()
    {
        $this->beConstructedWith(DummySpamDetector::withSpam());

        $this->detectsSpam('some spam')->shouldReturn(true);
    }

    function it_passes_when_no_spam_was_detected()
    {
        $this->beConstructedWith(DummySpamDetector::withoutSpam());

        $this->detectsSpam('No spam here!')->shouldReturn(false);
    }
}
