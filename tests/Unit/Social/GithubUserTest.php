<?php

namespace Tests\Unit\Social;

use App\Social\GithubUser;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;

class GithubUserTest extends TestCase
{
    /** @test */
    public function it_can_determine_if_the_user_is_older_than_two_weeks()
    {
        $user = new GithubUser(['created_at' => Carbon::now()->subWeeks(3)]);

        $this->assertFalse($user->isTooYoung());
    }

    /** @test */
    public function it_can_determine_if_the_user_is_younger_than_two_weeks()
    {
        $user = new GithubUser(['created_at' => Carbon::now()->subWeek()]);

        $this->assertTrue($user->isTooYoung());
    }
}
