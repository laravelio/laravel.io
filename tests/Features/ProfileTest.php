<?php

namespace Tests\Features;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\BrowserKitTestCase;

class ProfileTest extends BrowserKitTestCase
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
