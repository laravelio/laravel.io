<?php

use App\Rules\HttpImageRule;

it('passes when no http links are detected', function () {
    (new HttpImageRule())->validate('body', 'some text ![](https://link.com)', fn () => throw new Exception());
})->throwsNoExceptions();

it('fails when http links are detected', function () {
    (new HttpImageRule())->validate('body', 'some text ![](http://link.com)', fn () => throw new Exception());
})->throws(Exception::class);
