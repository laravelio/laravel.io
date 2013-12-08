<?php namespace Lio\BladeParsing;

use Codeception\Util\Stub;
use Mockery;

class BladeParserTest extends \Codeception\TestCase\Test
{
    protected $codeGuy;

    protected function _before() {}
    protected function _after() {}

    // tests
    public function testCanCreate()
    {
        $this->assertInstanceOf('Lio\BladeParsing\BladeParser', $this->getParser());
    }

    public function testCanParseWithoutTags()
    {
        $parser = $this->getParser();
        $text = "But it's the truth even if it didn't happen.";
        $this->assertEquals($text, $parser->parse($text));
    }

    public function testCanParseWithTags()
    {
        $parser = $this->getParser();

        // one tag
        $tag = Mockery::mock('Lio\BladeParsing\BladeTag');
        $tag->shouldReceive('getMatchCount')->andReturn(1);
        $tag->shouldReceive('transform')->andReturn('robots');

        $parser->addTag($tag);
        $text = "But it's the truth even if it didn't happen.";
        $this->assertEquals('robots', $parser->parse($text));

        // two tags
        $tag = Mockery::mock('Lio\BladeParsing\BladeTag');
        $tag->shouldReceive('getMatchCount')->andReturn(2);
        $tag->shouldReceive('transform')->andReturn('cats');

        $parser->addTag($tag);
        $text = "But it's the truth even if it didn't happen.";
        $this->assertEquals('cats', $parser->parse($text));
    }

    // ---------- private ------------ //
    private function getParser()
    {
        return new BladeParser;
    }
}