<?php

namespace spec\App\Rules;

use App\Rules\HttpImageRule;
use PhpSpec\ObjectBehavior;

class HttpImageRuleSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(HttpImageRule::class);
    }

    public function it_passes_when_no_http_links_are_detected()
    {
        $this->passes('body', 'some text ![](https://link.com)')->shouldReturn(true);
    }

    public function it_fails_when_http_links_are_detected()
    {
        $this->passes('body', 'some text ![](http://link.com)')->shouldReturn(false);
    }
}
