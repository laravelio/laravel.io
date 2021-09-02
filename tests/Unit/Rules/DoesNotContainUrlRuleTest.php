<?php

use App\Rules\DoesNotContainUrlRule;

it('detects a url in a string', function () {
    $this->assertFalse(
        (new DoesNotContainUrlRule())->passes('foo', 'This is a string http://example.com with an url in it.'),
    );
});

it('passes when no url is present', function () {
    $this->assertTrue(
        (new DoesNotContainUrlRule())->passes('foo', 'This is a string without an url in it.'),
    );
});

it('passes when extra spaces are present', function () {
    $this->assertTrue(
        (new DoesNotContainUrlRule())->passes('foo', 'This  is a  string with extra spaces.'),
    );
});
