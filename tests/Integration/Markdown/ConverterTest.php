<?php

use App\Markdown\Converter;
use Tests\TestCase;

uses(TestCase::class);

it('can detect mention links', function () {
    $converter = app()->make(Converter::class);

    $html = $converter->toHtml('Hello @johndoe');

    expect($html)->toBe('<p>Hello <a href="http://laravel.io.test/user/johndoe">@johndoe</a></p>'.PHP_EOL);
});

it('can detect mention links with html', function () {
    $converter = app()->make(Converter::class);

    $html = $converter->toHtml('<form></form> Hello @johndoe');

    expect($html)->toBe('&lt;form&gt;&lt;/form&gt; Hello <a href="http://laravel.io.test/user/johndoe">@johndoe</a>'.PHP_EOL);
});
