<?php

use Tests\TestCase;

uses(TestCase::class);

test('bcrypt hashing rounds reduced for faster test execution', function () {
    $this->assertEquals(4, config('hashing.bcrypt.rounds'));
});
