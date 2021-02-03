<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function it_can_determine_if_it_has_a_password_set()
    {
        $user = new User(['password' => 'foo']);

        $this->assertTrue($user->hasPassword());
    }
}
