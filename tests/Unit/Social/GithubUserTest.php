<?php

use App\Social\GithubUser;
use Carbon\Carbon;


it('can determine if the user is older than two weeks', function () {
    $user = new GithubUser(['created_at' => Carbon::now()->subWeeks(3)]);

    $this->assertFalse($user->isTooYoung());
});

it('can determine if the user is younger than two weeks', function () {
    $user = new GithubUser(['created_at' => Carbon::now()->subWeek()]);

    $this->assertTrue($user->isTooYoung());
});
