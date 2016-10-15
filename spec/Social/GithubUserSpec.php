<?php

namespace spec\App\Social;

use App\Social\GithubUser;
use Carbon\Carbon;
use PhpSpec\ObjectBehavior;

class GithubUserSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith([]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(GithubUser::class);
    }

    function it_can_determine_if_the_user_is_older_than_two_weeks()
    {
        $this->beConstructedWith(['created_at' => Carbon::now()->subWeek(3)]);

        $this->isYoungerThanTwoWeeks()->shouldReturn(false);
    }

    function it_can_determine_if_the_user_is_younger_than_two_weeks()
    {
        $this->beConstructedWith(['created_at' => Carbon::now()->subWeek(1)]);

        $this->isYoungerThanTwoWeeks()->shouldReturn(true);
    }
}
