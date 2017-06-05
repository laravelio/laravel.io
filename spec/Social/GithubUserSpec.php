<?php

namespace spec\App\Social;

use Carbon\Carbon;
use App\Social\GithubUser;
use PhpSpec\ObjectBehavior;

class GithubUserSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith([]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(GithubUser::class);
    }

    public function it_can_determine_if_the_user_is_older_than_two_weeks()
    {
        $this->beConstructedWith(['created_at' => Carbon::now()->subWeek(3)]);

        $this->isTooYoung()->shouldReturn(false);
    }

    public function it_can_determine_if_the_user_is_younger_than_two_weeks()
    {
        $this->beConstructedWith(['created_at' => Carbon::now()->subWeek(1)]);

        $this->isTooYoung()->shouldReturn(true);
    }
}
