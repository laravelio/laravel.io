<?php

use Tests\TestCase;

uses(TestCase::class);

test('converts markdown to safe html', function () {
    $body = 'Hello, World! ![](image.png).';

    expect(md_to_html($body))->toBe('<p>Hello, World! <img src="image.png" alt="" />.</p>'."\n");
});

test('prevents unsafe links', function () {
    $body = "[Unsafe Link](javascript:alert('Hello'))";

    expect(md_to_html($body))->toBe('<p><a>Unsafe Link</a></p>'."\n");
});

test('escapes executable html while preserving code examples', function (string $body) {
    foreach ([[], ['nofollow' => false]] as $params) {
        $html = md_to_html($body, $params);

        expect($html)->toContain('&lt;script&gt;')->not->toContain('<script>');
    }
})->with([
    '<script>alert(document.cookie);</script>',
    "```html\n<script>alert(document.cookie);</script>\n```",
    '`<script>alert(document.cookie);</script>`',
]);

test('removes unsafe markdown link and image destinations', function (string $url) {
    foreach ([[], ['nofollow' => false]] as $params) {
        $html = md_to_html('[link]('.$url.') ![image]('.$url.')', $params);

        expect($html)->toContain('<a>link</a>', '<img src="" alt="image" />');
    }
})->with([
    'javascript:alert(1)',
    'JaVaScRiPt:alert(1)',
    'jav&#x61;script:alert(1)',
    'vbscript:msgbox(1)',
    'data:text/html;base64,PHNjcmlwdD4=',
]);
