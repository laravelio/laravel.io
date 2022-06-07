<?php

use App\Markdown\Converter;
use Tests\TestCase;

uses(TestCase::class);

it('can detect mention links', function () {
    $converter = app()->make(Converter::class);

    $html = $converter->toHtml('Hello @johndoe');

    expect($html)->toBe('<p>Hello <a href="http://localhost/user/johndoe">@johndoe</a></p>'.PHP_EOL);
});

it('does not render mentions when the block starts with HTML', function () {
    $converter = app()->make(Converter::class);

    $html = $converter->toHtml('<form></form> Hello @johndoe');

    expect($html)->toBe('&lt;form&gt;&lt;/form&gt; Hello @johndoe'.PHP_EOL);
});
