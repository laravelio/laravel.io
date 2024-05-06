<?php

test('converts markdown to safe html', function () {
    $body = 'Hello, World! ![](image.png).';

    expect(md_to_safe_html($body))->toBe('<p>Hello, World! <img src="image.png" alt="" />.</p>' . "\n");
});

test('prevents unsafe links', function () {
    $body = "[Unsafe Link](javascript:alert('Hello'))";

    expect(md_to_safe_html($body))->toBe('<p><a>Unsafe Link</a></p>' . "\n");
});
