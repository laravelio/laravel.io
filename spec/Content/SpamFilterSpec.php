<?php

namespace spec\Lio\Content;

use Lio\Content\ForeignLanguageSpamDetector;
use Lio\Content\PhoneNumberSpamDetector;
use Lio\Content\SpamDetector;
use Lio\Content\SpamFilter;
use PhpSpec\ObjectBehavior;

class SpamFilterSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith([
            new PhoneNumberSpamDetector(),
            new ForeignLanguageSpamDetector(),
        ]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(SpamFilter::class);
        $this->shouldHaveType(SpamDetector::class);
    }

    public function it_can_detect_spam()
    {
        $this->detectsSpam('91+7742228242')->shouldReturn(true);
        $this->detectsSpam('【빠나나９넷】')->shouldReturn(true);
    }

    public function it_passes_when_no_spam_was_detected()
    {
        $this->detectsSpam('No spam here!')->shouldReturn(false);
    }
}
