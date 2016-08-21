<?php

namespace Tests\Functional;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function show_profile()
    {
        $this->createUser();

        $this->visit('/user/johndoe')
            ->see('John Doe');
    }
}
