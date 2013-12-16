<?php namespace Lio\Markdown;

use HTML_To_Markdown;

class HtmlMarkdownConvertor
{
    protected $htmlParser;
    protected $markdownParser;

    public function __construct()
    {
        $this->htmlParser = new HTML_To_markdown;
        $this->htmlParser->set_option('header_style', 'atx');

        $this->markdownParser = new \Michelf\MarkdownExtra;
    }

    public function convertHtmlToMarkdown($html)
    {
        return $this->htmlParser->convert($html);
    }

    public function convertMarkdownToHtml($markdown)
    {
        return $this->markdownParser->transform($markdown);
    }
}