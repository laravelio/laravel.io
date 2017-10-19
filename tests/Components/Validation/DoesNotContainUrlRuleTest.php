<?php

namespace Tests\Components\Validation;

use Tests\TestCase;
use App\Validation\DoesNotContainUrlRule;

class DoesNotContainUrlRuleTest extends TestCase
{
    const STRING_WITH_URL = 'This is a string http://example.com with an url in it.';
    const STRING_WITHOUT_URL = 'This is a string without an url in it.';
    const STRING_WITH_EXTRA_SPACES = 'This  is a  string with extra spaces.';

    /** @test */
    public function it_detects_a_url_in_a_string()
    {
        $this->assertFalse($this->runRule(self::STRING_WITH_URL));
    }

    /** @test */
    public function it_passes_when_no_url_is_present()
    {
        $this->assertTrue($this->runRule(self::STRING_WITHOUT_URL));
    }

    /** @test */
    public function it_passes_when_extra_spaces_are_present()
    {
        $this->assertTrue($this->runRule(self::STRING_WITH_EXTRA_SPACES));
    }

    private function runRule(string $value): bool
    {
        return $this->app->make(DoesNotContainUrlRule::class)->validate(null, $value);
    }
}
