<?php

namespace Tests\Feature;

use App\Models\Tag;
use App\Models\Thread;
use Tests\BrowserKitTestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ForumTest extends BrowserKitTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function users_can_see_a_list_of_latest_threads()
    {
        factory(Thread::class)->create(['subject' => 'The first thread']);
        factory(Thread::class)->create(['subject' => 'The second thread']);

        $this->visit('/forum')
            ->see('The first thread')
            ->see('The second thread');
    }

    /** @test */
    public function users_can_see_a_single_thread()
    {
        factory(Thread::class)->create([
            'subject' => 'The first thread',
            'slug' => 'the-first-thread',
        ]);

        $this->visit('/forum/the-first-thread')
            ->see('The first thread');
    }

    /** @test */
    public function users_cannot_create_a_thread_when_not_logged_in()
    {
        $this->visit('/forum/create-thread')
            ->seePageIs('/login');
    }

    /** @test */
    public function the_thread_subject_cannot_be_an_url()
    {
        $tag = factory(Tag::class)->create(['name' => 'Test Tag']);

        $this->login();

        $this->visit('/forum/create-thread')
            ->submitForm('Create Thread', [
                'subject' => 'http://example.com Foo title',
                'body' => 'This text explains how to work with Eloquent.',
                'tags' => [$tag->id()],
            ])
            ->seePageIs('/forum/create-thread')
            ->see('The subject field cannot contain an url.');
    }

    /** @test */
    public function users_can_create_a_thread()
    {
        $tag = factory(Tag::class)->create(['name' => 'Test Tag']);

        $this->login();

        $this->visit('/forum/create-thread')
            ->submitForm('Create Thread', [
                'subject' => 'How to work with Eloquent?',
                'body' => 'This text explains how to work with Eloquent.',
                'tags' => [$tag->id()],
            ])
            ->seePageIs('/forum/how-to-work-with-eloquent')
            ->see('How to work with Eloquent?')
            ->see('Test Tag')
            ->see('Thread successfully created!');
    }

    /** @test */
    public function users_can_edit_a_thread()
    {
        $user = $this->createUser();
        $tag = factory(Tag::class)->create(['name' => 'Test Tag']);
        factory(Thread::class)->create([
            'author_id' => $user->id(),
            'slug' => 'my-first-thread',
        ]);

        $this->loginAs($user);

        $this->visit('/forum/my-first-thread/edit')
            ->submitForm('Update Thread', [
                'subject' => 'How to work with Eloquent?',
                'body' => 'This text explains how to work with Eloquent.',
                'tags' => [$tag->id()],
            ])
            ->seePageIs('/forum/how-to-work-with-eloquent')
            ->see('How to work with Eloquent?')
            ->see('Test Tag')
            ->see('Thread successfully updated!');
    }

    /** @test */
    public function users_cannot_edit_a_thread_they_do_not_own()
    {
        factory(Thread::class)->create(['slug' => 'my-first-thread']);

        $this->login();

        $this->get('/forum/my-first-thread/edit')
            ->assertForbidden();
    }

    /** @test */
    public function users_cannot_delete_a_thread_they_do_not_own()
    {
        factory(Thread::class)->create(['slug' => 'my-first-thread']);

        $this->login();

        $this->delete('/forum/my-first-thread')
            ->assertForbidden();
    }

    /** @test */
    public function users_cannot_create_a_thread_with_a_subject_that_is_too_long()
    {
        $tag = factory(Tag::class)->create(['name' => 'Test Tag']);

        $this->login();

        $this->visit('/forum/create-thread')
            ->submitForm('Create Thread', [
                'subject' => 'How to make Eloquent, Doctrine, Entities and Annotations work together in Laravel?',
                'body' => 'This is a thread with 82 characters in the subject',
                'tags' => [$tag->id()],
            ])
            ->seePageIs('/forum/create-thread')
            ->see('Something went wrong. Please review the fields below.')
            ->see('The subject may not be greater than 60 characters.');
    }

    /** @test */
    public function users_cannot_edit_a_thread_with_a_subject_that_is_too_long()
    {
        $user = $this->createUser();
        $tag = factory(Tag::class)->create(['name' => 'Test Tag']);
        factory(Thread::class)->create([
            'author_id' => $user->id(),
            'slug' => 'my-first-thread',
        ]);

        $this->loginAs($user);

        $this->visit('/forum/my-first-thread/edit')
            ->submitForm('Update Thread', [
                'subject' => 'How to make Eloquent, Doctrine, Entities and Annotations work together in Laravel?',
                'body' => 'This is a thread with 82 characters in the subject',
                'tags' => [$tag->id()],
            ])
            ->seePageIs('/forum/my-first-thread/edit')
            ->see('Something went wrong. Please review the fields below.')
            ->see('The subject may not be greater than 60 characters.');
    }
}
