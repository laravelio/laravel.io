<?php

use App\Ai\Agents\SpamModerator;
use App\Livewire\EditReply;
use App\Models\Reply;
use App\Models\Tag;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

test('spam submissions are rejected and banned users cannot retry', function (string $type) {
    $user = $this->createUser();
    $thread = Thread::factory()->create(['created_at' => now()]);
    $tag = Tag::factory()->create();
    $this->loginAs($user);
    SpamModerator::fake([['is_spam' => true]])->preventStrayPrompts();

    $url = $type === 'thread' ? '/forum/create-thread' : '/replies';
    $data = $type === 'thread'
        ? ['subject' => 'Buy this product', 'body' => 'Spam advertisement', 'tags' => [$tag->id()]]
        : ['body' => 'Spam advertisement', 'replyable_id' => $thread->id(), 'replyable_type' => Thread::TABLE];

    $this->post($url, $data)->assertSessionHasErrors('body')->assertSessionMissing('success');

    expect($user->fresh()->bannedReason())->toBe('Spam - banned by AI');
    $this->assertDatabaseMissing($type === 'thread' ? 'threads' : 'replies', ['body' => 'Spam advertisement']);

    $this->post($url, $data)->assertForbidden();

    $this->actingAs($user->fresh());
    $this->post($url, $data)->assertRedirect(route('home'));
    $this->assertGuest();
    SpamModerator::assertPromptedTimes(1);
})->with(['thread', 'reply']);

test('spam reply edits show validation errors and preserve the published reply', function () {
    $user = $this->createUser();
    $reply = Reply::factory()->create(['author_id' => $user->id(), 'body' => 'Original answer']);
    $this->loginAs($user);
    SpamModerator::fake([['is_spam' => true]])->preventStrayPrompts();

    Livewire::test(EditReply::class, ['reply' => $reply])
        ->call('updateReply', 'Spam advertisement')
        ->assertHasErrors('body')
        ->assertNotDispatched('replyEdited');

    expect($reply->fresh()->body())->toBe('Original answer')
        ->and($user->fresh()->bannedReason())->toBe('Spam - banned by AI');
});
