<?php

namespace Tests\Integration\Queries;

use App\Queries\SearchUsers;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SearchUsersTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_search_by_name_or_email_or_username()
    {
        User::factory()->create(['name' => 'Freek Murze', 'email' => 'freek@freek.com']);
        User::factory()->create(['name' => 'Frederick Vanbrabant', 'email' => 'vanbra@vanbra.com']);

        $this->assertCount(2, SearchUsers::get('fre'));
        $this->assertCount(1, SearchUsers::get('van'));
    }
}
