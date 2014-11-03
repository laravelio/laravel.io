<?php
namespace Lio\Tests\Unit\GitHub;

use Lio\Github\GistEmbedFormatter;
use Lio\Tests\TestCase;
use Mockery;

class GistEmbedFormatterTest extends TestCase
{
    public function testCanCreate()
    {
        $this->assertInstanceOf('Lio\GitHub\GistEmbedFormatter', $this->getFormatter());
    }

    public function testCanFormat()
    {
        $formatter = $this->getFormatter();

        $gistUrl = 'https://gist.github.com/username/1';
        $embedHtml = '<script src="https://gist.github.com/username/1.js"></script>';
        $this->assertEquals($embedHtml, $formatter->format($gistUrl));
    }

    public function testCanFormatMany()
    {
        $formatter = $this->getFormatter();

        $gistUrl = '
“Good writin\' ain\'t necessarily good readin.”
        https://gist.github.com/username/a773c725e4e9c19e36f0
https://gist.github.com/username/7712371
What makes people so impatient is what I can\'t figure; all the guy had to do was wait.
https://gist.github.com/username/1
        https://gist.github.com/username/2
';
        $embedHtml = '
“Good writin\' ain\'t necessarily good readin.”
        <script src="https://gist.github.com/username/a773c725e4e9c19e36f0.js"></script>
<script src="https://gist.github.com/username/7712371.js"></script>
What makes people so impatient is what I can\'t figure; all the guy had to do was wait.
<script src="https://gist.github.com/username/1.js"></script>
        <script src="https://gist.github.com/username/2.js"></script>
';
        $this->assertEquals($embedHtml, $formatter->format($gistUrl));
    }

    private function getFormatter()
    {
        return new GistEmbedFormatter;
    }
}