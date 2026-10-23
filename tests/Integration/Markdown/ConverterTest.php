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

it('renders fixed provider iframes directly from URLs', function (string $url, ?string $src) {
    $html = md_to_html($url);

    expect($html)->not->toContain('<script', 'onerror', 'onload', 'attacker.example');

    if ($src === null) {
        expect($html)->not->toContain('<iframe')->toContain('<a ');
    } else {
        expect($html)->toContain('<iframe src="'.$src.'"')
            ->toContain('referrerpolicy="strict-origin-when-cross-origin"');
    }
})->with([
    ['https://youtube.com/watch?v=x', 'https://www.youtube.com/embed/x'],
    ['https://www.youtube.com/watch?v=x', 'https://www.youtube.com/embed/x'],
    ['http://youtube.com/watch?v=x', null],
    ['https://www.youtube.com/embed/x', 'https://www.youtube.com/embed/x'],
    ['https://unresolvable-subdomain.youtube.com/watch?v=x', 'https://www.youtube.com/embed/x'],
    ['https://twitter.com/u/status/1', 'https://platform.twitter.com/embed/Tweet.html?id=1'],
    ['https://x.com/u/status/1', 'https://platform.twitter.com/embed/Tweet.html?id=1'],
    ['https://youtube.com/shorts/abc-123', 'https://www.youtube.com/embed/abc-123'],
    ['https://youtube.com/watch?v=x&html=%3Cscript%3Ealert(1)%3C%2Fscript%3E', 'https://www.youtube.com/embed/x'],
    ['https://youtube.com/watch?v%5B%5D=x', null],
    ['https://youtube.com/watch?v=x%22%3E%3Cscript%3E', null],
    ['https://x.com/u/status/invalid', null],
]);

it('keeps blocked embed URLs as links', function (string $url) {
    expect(md_to_html($url))->not->toContain('<iframe', '<script')
        ->toContain('<a ');
})->with([
    'https://youtube.com@attacker.example/',
    'https://youtube.com.attacker.example/',
    'http://youtube.com.169.254.169.254.nip.io/',
    'https://evilyoutube.com/',
    'http://169.254.169.254/',
    'https://youtube.com:pw@attacker.example/',
    'https://user:pw@youtube.com/watch?v=x',
    'https://@youtube.com/watch?v=x',
    'ftp://youtube.com/',
]);

it('escapes executable HTML alongside embeds', function () {
    $html = md_to_html(<<<'MARKDOWN'
https://youtube.com/watch?v=x

<script>alert(1)</script>

<iframe src="https://attacker.example/" onload="alert(1)"></iframe>

<img src="x" onerror="alert(1)">
MARKDOWN);

    $document = new DOMDocument;
    $document->loadHTML($html);
    $xpath = new DOMXPath($document);

    expect($xpath->query('//script | //*[@onload or @onerror or @srcdoc]')->length)->toBe(0)
        ->and($xpath->query('//iframe')->length)->toBe(1)
        ->and($xpath->query('//iframe')->item(0)->getAttribute('src'))->toBe('https://www.youtube.com/embed/x');
});
