<?php

use App\Rules\HttpImageRule;

it('passes when no http links are detected', function () {
    $this->assertTrue(
        (new HttpImageRule())->passes('body', 'some text ![](https://link.com)'),
    );
});

it('fails when http links are detected', function () {
    $this->assertFalse(
        (new HttpImageRule())->passes('body', 'some text ![](http://link.com)'),
    );
});
