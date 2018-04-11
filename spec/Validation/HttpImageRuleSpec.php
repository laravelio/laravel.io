<?php

namespace spec\App\Validation;

use App\Validation\HttpImageRule;
use PhpSpec\ObjectBehavior;

class HttpImageRuleSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(HttpImageRule::class);
    }

    public function it_passes_when_no_http_links_are_detected()
    {
        $this->validate('body', 'some text ![](https://link.com)')->shouldReturn(true);
    }

    public function it_fails_when_http_links_are_detected()
    {
        $this->validate('body', 'some text ![](http://link.com)')->shouldReturn(false);
    }
}
