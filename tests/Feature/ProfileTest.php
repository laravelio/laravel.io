<?php

namespace Tests\Feature;

use Tests\BrowserKitTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfileTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function anyone_can_see_a_user_profile()
    {
        $this->createUser();

        $this->visit('/user/johndoe')
            ->see('John Doe');
    }
}
