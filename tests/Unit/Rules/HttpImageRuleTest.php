<?php

namespace Tests\Unit\Rules;

use App\Rules\HttpImageRule;
use PHPUnit\Framework\TestCase;

class HttpImageRuleTest extends TestCase
{
    /** @test */
    public function it_passes_when_no_http_links_are_detected()
    {
        $this->assertTrue(
            (new HttpImageRule())->passes('body', 'some text ![](https://link.com)'),
        );
    }

    /** @test */
    public function it_fails_when_http_links_are_detected()
    {
        $this->assertFalse(
            (new HttpImageRule())->passes('body', 'some text ![](http://link.com)'),
        );
    }
}
