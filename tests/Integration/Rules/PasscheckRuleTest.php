<?php

use App\Rules\PasscheckRule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class);
uses(RefreshDatabase::class);

it('passes when the password is correct', function () {
    $this->login(['password' => bcrypt('foo')]);
    $rule = new PasscheckRule();

    $rule->validate('password', 'foo', fn () => throw new Exception());
})->throwsNoExceptions();

it('fails when the password is incorrect', function () {
    $this->login();
    $rule = new PasscheckRule();

    $rule->validate('password', 'foo', fn () => throw new Exception());
})->throws(Exception::class);
