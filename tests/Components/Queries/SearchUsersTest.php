<?php

namespace Tests\Components\Queries;

use App\User;
use Tests\TestCase;
use App\Queries\SearchUsers;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SearchUsersTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_search_by_name_or_email_or_username()
    {
        factory(User::class)->create(['name' => 'Freek Murze', 'email' => 'freek@freek.com']);
        factory(User::class)->create(['name' => 'Frederick Vanbrabant', 'email' => 'vanbra@vanbra.com']);

        $this->assertCount(2, SearchUsers::get('fre'));
        $this->assertCount(1, SearchUsers::get('van'));
    }
}
