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
	$this->htmlParser->set_option('strip_tags', true);


        $this->markdownParser = new \Michelf\MarkdownExtra;
        $this->markdownParser->no_markup = true;
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
