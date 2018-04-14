<?php

namespace spec\App\Validation;

use PhpSpec\ObjectBehavior;
use App\Validation\DoesNotContainUrlRule;

class DoesNotContainUrlRuleSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(DoesNotContainUrlRule::class);
    }

    public function it_detects_a_url_in_a_string()
    {
        $this->passes('foo', 'This is a string http://example.com with an url in it.')->shouldReturn(false);
    }

    public function it_passes_when_no_url_is_present()
    {
        $this->passes('foo', 'This is a string without an url in it.')->shouldReturn(true);
    }

    public function it_passes_when_extra_spaces_are_present()
    {
        $this->passes('foo', 'This  is a  string with extra spaces.')->shouldReturn(true);
    }
}
