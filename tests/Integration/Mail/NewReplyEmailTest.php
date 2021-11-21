<?php

use App\Mail\NewReplyEmail;
use App\Models\Reply;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

uses(TestCase::class);
uses(DatabaseMigrations::class);

it('contains a note about solutions when the receiver is the thread author', function () {
    $reply = Reply::factory()->create();
    $thread = $reply->replyAble();
    $subscription = Subscription::factory()->create(['subscriptionable_id' => $thread->id]);

    $email = (new NewReplyEmail($reply, $subscription, $thread->author()))->render();

    expect($email)
        ->toContain('Please make sure to mark the correct reply as the solution when your question gets answered.');
});

it('misses the note about solutions when the receiver is not the thread author', function () {
    $reply = Reply::factory()->create();
    $thread = $reply->replyAble();
    $user = User::factory()->create();
    $subscription = Subscription::factory()->create(['subscriptionable_id' => $thread->id]);

    $email = (new NewReplyEmail($reply, $subscription, $user))->render();

    expect($email)->not
        ->toContain('Please make sure to mark the correct reply as the solution when your question gets answered.');
});
