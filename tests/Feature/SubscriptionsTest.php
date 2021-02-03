<?php

namespace Tests\Feature;

use App\Jobs\CreateReply;
use App\Jobs\CreateThread;
use App\Models\Subscription;
use App\Models\Thread;
use App\Models\User;
use App\Notifications\NewReplyNotification;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;

class SubscriptionsTest extends BrowserKitTestCase
{
    use DatabaseMigrations;
    use WithFaker;

    /** @test */
    public function users_receive_notifications_for_new_replies_to_threads_where_they_are_subscribed_to()
    {
        Notification::fake();

        $thread = Thread::factory()->create();
        [$author, $userOne, $userTwo] = User::factory()->times(3)->create();
        Subscription::factory()->create(['user_id' => $userOne->id(), 'subscriptionable_id' => $thread->id()]);
        Subscription::factory()->create(['user_id' => $userTwo->id(), 'subscriptionable_id' => $thread->id()]);

        $this->dispatch(new CreateReply($this->faker->text, $author, $thread));

        Notification::assertNotSentTo($author, NewReplyNotification::class);
        Notification::assertSentTo([$userOne, $userTwo], NewReplyNotification::class);
    }

    /** @test */
    public function users_are_automatically_subscribed_to_a_thread_after_creating_it()
    {
        $user = $this->createUser();

        $thread = $this->dispatch(new CreateThread($this->faker->sentence, $this->faker->text, $user));

        $this->assertTrue($thread->hasSubscriber($user));
    }

    /** @test */
    public function thread_authors_do_not_receive_a_notification_for_a_thread_they_create()
    {
        Notification::fake();

        $author = $this->createUser();

        $this->dispatch(new CreateThread($this->faker->sentence, $this->faker->text, $author));

        Notification::assertNotSentTo($author, NewReplyNotification::class);
    }

    /** @test */
    public function reply_authors_do_not_receive_a_notification_for_a_thread_they_are_subscribed_to()
    {
        Notification::fake();

        $thread = Thread::factory()->create();
        $author = User::factory()->create();
        Subscription::factory()->create(['user_id' => $author->id(), 'subscriptionable_id' => $thread->id()]);

        $this->dispatch(new CreateReply($this->faker->text, $author, $thread));

        Notification::assertNotSentTo($author, NewReplyNotification::class);
    }

    /** @test */
    public function users_are_automatically_subscribed_to_a_thread_after_replying_to_it()
    {
        $user = $this->createUser();
        $thread = Thread::factory()->create();

        $this->dispatch(new CreateReply($this->faker->text, $user, $thread));

        $this->assertTrue($thread->hasSubscriber($user));
    }

    /** @test */
    public function users_can_manually_subscribe_to_threads()
    {
        Thread::factory()->create(['slug' => $slug = $this->faker->slug]);

        $this->login();

        $this->visit("/forum/$slug")
            ->click('Subscribe')
            ->seePageIs("/forum/$slug")
            ->see("You're now subscribed to this thread.");
    }

    /** @test */
    public function users_can_unsubscribe_from_threads()
    {
        $user = $this->createUser();
        $thread = Thread::factory()->create(['slug' => $slug = $this->faker->slug]);
        Subscription::factory()->create(['user_id' => $user->id(), 'subscriptionable_id' => $thread->id()]);

        $this->loginAs($user);

        $this->visit("/forum/$slug")
            ->click('Unsubscribe')
            ->seePageIs("/forum/$slug")
            ->see("You're now unsubscribed from this thread.");
    }

    /** @test */
    public function users_can_unsubscribe_through_a_token_link()
    {
        $subscription = Subscription::factory()->create();
        $thread = $subscription->subscriptionAble();

        $this->visit("/subscriptions/{$subscription->uuid()}/unsubscribe")
            ->seePageIs("/forum/{$thread->slug()}")
            ->see("You're now unsubscribed from this thread.");

        $this->notSeeInDatabase('subscriptions', ['uuid' => $subscription->uuid()]);
    }
}
