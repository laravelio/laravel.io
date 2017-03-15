<?php

namespace Lio\Tests\Unit\Markdown;

use Lio\Markdown\HtmlMarkdownConvertor;
use Lio\Tests\TestCase;

class HtmlToMarkdownConvertorTest extends TestCase
{
    public function testCanCreate()
    {
        $this->assertInstanceOf('Lio\Markdown\HtmlMarkdownConvertor', $this->getConvertor());
    }

    public function testCanConvertHtmlToMarkdown()
    {
        $conv = $this->getConvertor();

        $this->assertEquals('', $conv->convertHtmlToMarkdown(''));
        $this->assertEquals('**cats**', $conv->convertHtmlToMarkdown('<strong>cats</strong>'));
        $this->assertEquals('*cats*', $conv->convertHtmlToMarkdown('<em>cats</em>'));
        $this->assertEquals('***cats***', $conv->convertHtmlToMarkdown('<strong><em>cats</em></strong>'));
        $this->assertEquals('# Robots', $conv->convertHtmlToMarkdown('<h1>Robots</h1>'));
        $this->assertEquals('## Robots', $conv->convertHtmlToMarkdown('<h2>Robots</h2>'));
        $this->assertEquals('### Robots', $conv->convertHtmlToMarkdown('<h3>Robots</h3>'));
        $this->assertEquals('#### Robots', $conv->convertHtmlToMarkdown('<h4>Robots</h4>'));
        $this->assertEquals('    Robots', $conv->convertHtmlToMarkdown("<code>\nRobots\n</code>"));
        $this->assertEquals('    Robots', $conv->convertHtmlToMarkdown("<pre><code>Robots\n</code></pre>\n"));
        $this->assertEquals('    Robots', $conv->convertHtmlToMarkdown("<p><code>Robots\n</code></p>"));
        $this->assertEquals('`Robots`', $conv->convertHtmlToMarkdown('<code>Robots</code>'));
        $this->assertEquals('`Robots`', $conv->convertHtmlToMarkdown("<pre><code>Robots</code></pre>\n"));
        $this->assertEquals('`Robots`', $conv->convertHtmlToMarkdown('<p><code>Robots</code></p>'));
    }

    public function testCanConvertMarkdownToHtml()
    {
        $conv = $this->getConvertor();

        $this->assertEquals(PHP_EOL, $conv->convertMarkdownToHtml(''));
        $this->assertEquals('<p><strong>cats</strong></p>'.PHP_EOL, $conv->convertMarkdownToHtml('**cats**'));
        $this->assertEquals('<p><em>cats</em></p>'.PHP_EOL, $conv->convertMarkdownToHtml('*cats*'));
        $this->assertEquals('<p><strong><em>cats</em></strong></p>'.PHP_EOL, $conv->convertMarkdownToHtml('***cats***'));
        $this->assertEquals('<h1>Robots</h1>'.PHP_EOL, $conv->convertMarkdownToHtml('# Robots'));
        $this->assertEquals('<h2>Robots</h2>'.PHP_EOL, $conv->convertMarkdownToHtml('## Robots'));
        $this->assertEquals('<h3>Robots</h3>'.PHP_EOL, $conv->convertMarkdownToHtml('### Robots'));
        $this->assertEquals('<h4>Robots</h4>'.PHP_EOL, $conv->convertMarkdownToHtml('#### Robots'));
        $this->assertEquals('<pre><code>Robots'.PHP_EOL.'</code></pre>'.PHP_EOL, $conv->convertMarkdownToHtml('    Robots'));
        $this->assertEquals('<p><code>Robots</code></p>'.PHP_EOL, $conv->convertMarkdownToHtml('`Robots`'));
    }

    private function getConvertor()
    {
        return new HtmlMarkdownConvertor();
    }
}
