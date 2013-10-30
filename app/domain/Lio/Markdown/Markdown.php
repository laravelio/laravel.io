<?php namespace Lio\Markdown;

use \Michelf\MarkdownExtra;

class Markdown extends MarkdownExtra
{
    public function transform($content)
    {
        $parsedContent = parent::transform($content);
        $parsedContent = str_replace('<code>', '<code class="prettyprint">', $parsedContent);

        return $parsedContent;
    }
}