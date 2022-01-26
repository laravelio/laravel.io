<?php

use App\Http\Livewire\Editor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Livewire\Livewire;
use Tests\TestCase;

uses(TestCase::class);
uses(DatabaseMigrations::class);

test('participants are rendered when mentions are invoked', function () {
    $participants = User::factory()->count(3)->create();

    Livewire::test(Editor::class, ['participants' => $participants, 'hasMentions' => true])
        ->call('getUsers', '')
        ->assertSee($participants->first()->username())
        ->assertSee($participants->get(1)->username())
        ->assertSee($participants->get(2)->username());
});

test('users are returned when a query is made for mentions', function () {
    $userOne = User::factory()->create(['username' => 'joedixon']);
    $userTwo = User::factory()->create(['username' => 'driesvints']);

    Livewire::test(Editor::class, ['hasMentions' => true])
        ->call('getUsers', 'jo')
        ->assertSee($userOne->username())
        ->assertDontSee($userTwo->username());
});

test('participants are prioritised over users', function () {
    $participants = User::factory()
        ->count(2)
        ->state(new Sequence(
            ['username' => 'joedixon'],
            ['username' => 'driesvints'],
        ))
        ->create();
    User::factory()->create(['username' => 'janedoe']);

    Livewire::test(Editor::class, ['participants' => $participants, 'hasMentions' => true])
        ->call('getUsers', 'j')
        ->assertSeeInOrder(['joedixon', 'janedoe']);
});

test('users are not queried when hasMentions is turned off', function () {
    $users = User::factory()
        ->count(2)
        ->state(new Sequence(
            ['username' => 'joedixon'],
            ['username' => 'driesvints'],
        ))
        ->create();

    Livewire::test(Editor::class)
        ->call('getUsers', 'j')
        ->assertDontSee($users->first()->username());
});

test('no users are returned when query returns no results', function () {
    $users = User::factory()
        ->count(2)
        ->state(new Sequence(
            ['username' => 'joedixon'],
            ['username' => 'driesvints'],
        ))
        ->create();

    Livewire::test(Editor::class, ['hasMentions' => true])
        ->call('getUsers', 'b')
        ->assertDontSee($users->first()->username())
        ->assertDontSee($users->get(1)->username());
});
