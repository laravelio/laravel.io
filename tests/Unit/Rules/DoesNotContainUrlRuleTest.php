<?php

use App\Rules\DoesNotContainUrlRule;

it('detects a url in a string', function () {
    (new DoesNotContainUrlRule)->validate('foo', 'This is a string http://example.com with an url in it.', fn () => throw new Exception);
})->throws(Exception::class);

it('passes when no url is present', function () {
    (new DoesNotContainUrlRule)->validate('foo', 'This is a string without an url in it.', fn () => throw new Exception);
})->throwsNoExceptions();

it('passes when extra spaces are present', function () {
    (new DoesNotContainUrlRule)->validate('foo', 'This  is a  string with extra spaces.', fn () => throw new Exception);
})->throwsNoExceptions();
