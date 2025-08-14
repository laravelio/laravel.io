<?php

use App\Jobs\UnblockUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class);
uses(RefreshDatabase::class);

it('can unblock a user', function () {
    $unblocker = $this->createUser();
    $unblocked = $this->createUser([
        'username' => 'unblocked',
        'email' => 'unblocked@example.com',
    ]);

    $this->loginAs($unblocker);

    $this->dispatch(new UnblockUser($unblocker, $unblocked));

    expect($unblocker->hasUnblocked($unblocked))->toBeTrue();
});
