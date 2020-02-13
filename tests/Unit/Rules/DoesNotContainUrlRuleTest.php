<?php

namespace Tests\Unit\Rules;

use App\Rules\DoesNotContainUrlRule;
use PHPUnit\Framework\TestCase;

class DoesNotContainUrlRuleTest extends TestCase
{
    /** @test */
    public function it_detects_a_url_in_a_string()
    {
        $this->assertFalse(
            (new DoesNotContainUrlRule())->passes('foo', 'This is a string http://example.com with an url in it.')
        );
    }

    /** @test */
    public function it_passes_when_no_url_is_present()
    {
        $this->assertTrue(
            (new DoesNotContainUrlRule())->passes('foo', 'This is a string without an url in it.')
        );
    }

    /** @test */
    public function it_passes_when_extra_spaces_are_present()
    {
        $this->assertTrue(
            (new DoesNotContainUrlRule())->passes('foo', 'This  is a  string with extra spaces.')
        );
    }
}
