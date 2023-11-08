<?php

use App\Social\GitHubUser;
use Carbon\Carbon;

it('can determine if the user is older than two weeks', function () {
    $user = new GitHubUser(['created_at' => Carbon::now()->subWeeks(3)]);

    expect($user->isTooYoung())->toBeFalse();
});

it('can determine if the user is younger than two weeks', function () {
    $user = new GitHubUser(['created_at' => Carbon::now()->subWeek()]);

    expect($user->isTooYoung())->toBeTrue();
});

it('can determine if the user has public repositories', function (int $numberOfRepos, bool $expected) {
    $user = new GitHubUser(['public_repos' => $numberOfRepos]);

    expect($user->hasPublicRepositories())->toBe($expected);
})->with([
    [0, false],
    [1, true],
    [2, true],
    [3, true],
]);
