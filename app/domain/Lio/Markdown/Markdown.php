<?php namespace Lio\Markdown;

use \Michelf\MarkdownExtra;

class Markdown extends MarkdownExtra
{
    public function transform($content)
    {
        $parsedContent = parent::transform($content);

        $parsedContent = str_replace('<p><code>', '<pre><code>', $parsedContent);
        $parsedContent = str_replace('</code></p>', '</code></pre>', $parsedContent);

        $parsedContent = str_replace('<pre><code>', '<pre class="prettyprint"><code>', $parsedContent);

        return $parsedContent;
    }
}