<?php

use App\Models\User;
use App\Queries\SearchUsers;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

uses(TestCase::class);
uses(DatabaseMigrations::class);

it('can search by name or email or username', function () {
    User::factory()->create(['name' => 'Freek Murze', 'email' => 'freek@freek.com']);
    User::factory()->create(['name' => 'Frederick Vanbrabant', 'email' => 'vanbra@vanbra.com']);

    expect(SearchUsers::get('fre'))->toHaveCount(2);
    expect(SearchUsers::get('van'))->toHaveCount(1);
});
