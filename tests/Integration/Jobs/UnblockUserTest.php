<?php

use App\Jobs\UnblockUser;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

uses(TestCase::class);
uses(DatabaseTransactions::class);

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
