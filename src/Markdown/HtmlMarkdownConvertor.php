<?php namespace Lio\Markdown;

use HTML_To_Markdown;
use Michelf\MarkdownExtra;
use Purifier;

class HtmlMarkdownConvertor
{
    protected $htmlParser;
    protected $markdownParser;

    public function __construct()
    {
        $this->htmlParser = new HTML_To_markdown;
        $this->htmlParser->set_option('header_style', 'atx');

        $this->markdownParser = new MarkdownExtra;
        $this->markdownParser->no_markup = true;
    }

    public function convertHtmlToMarkdown($html)
    {
        return $this->htmlParser->convert($html);
    }

    public function convertMarkdownToHtml($markdown)
    {
        $html = $this->markdownParser->transform($markdown);
        return Purifier::clean($html, 'markdown');
    }
}