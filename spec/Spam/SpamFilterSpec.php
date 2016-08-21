<?php

namespace spec\App\Spam;

use App\Spam\ForeignLanguageSpamDetector;
use App\Spam\PhoneNumberSpamDetector;
use App\Spam\SpamDetector;
use App\Spam\SpamFilter;
use PhpSpec\ObjectBehavior;

class SpamFilterSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith([
            new PhoneNumberSpamDetector,
            new ForeignLanguageSpamDetector
        ]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(SpamFilter::class);
        $this->shouldHaveType(SpamDetector::class);
    }

    function it_can_detect_spam()
    {
        $this->detectsSpam('91+7742228242')->shouldReturn(true);
        $this->detectsSpam('【빠나나９넷】')->shouldReturn(true);
    }

    function it_passes_when_no_spam_was_detected()
    {
        $this->detectsSpam('No spam here!')->shouldReturn(false);
    }
}
