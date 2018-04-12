<?php

namespace Tests\Components\Validation;

use App\Validation\PasscheckRule;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasscheckRuleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_passes_when_the_password_is_correct()
    {
        $this->login(['password' => bcrypt('foo')]);
        $rule = new PasscheckRule;

        $result = $rule->passes('password', 'foo');

        $this->assertTrue($result);
    }

    /** @test */
    public function it_fails_when_the_password_is_incorrect()
    {
        $this->login();
        $rule = new PasscheckRule;

        $result = $rule->passes('password', 'foo');

        $this->assertFalse($result);
    }
}
