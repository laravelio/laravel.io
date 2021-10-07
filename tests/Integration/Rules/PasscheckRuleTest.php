<?php

use App\Rules\PasscheckRule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class);
uses(RefreshDatabase::class);

it('passes when the password is correct', function () {
    $this->login(['password' => bcrypt('foo')]);
    $rule = new PasscheckRule();

    $result = $rule->passes('password', 'foo');

    expect($result)->toBeTrue();
});

it('fails when the password is incorrect', function () {
    $this->login();
    $rule = new PasscheckRule();

    $result = $rule->passes('password', 'foo');

    expect($result)->toBeFalse();
});
