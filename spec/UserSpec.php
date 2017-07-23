<?php

namespace spec\App;

use App\User;
use PhpSpec\ObjectBehavior;

class UserSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(User::class);
    }

    public function it_can_determine_if_it_has_a_password_set()
    {
        $this->beConstructedWith(['password' => 'foo']);

        $this->hasPassword()->shouldReturn(true);
    }
}
