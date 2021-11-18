<?php

use App\Models\Article;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Feature\BrowserKitTestCase;

uses(BrowserKitTestCase::class);
uses(DatabaseMigrations::class);

test('requires login', function () {
    $this->visit('/admin')
        ->seePageIs('/login');
});

test('normal users cannot visit the admin section', function () {
    $this->login();

    $this->get('/admin')
        ->assertForbidden();
});

test('admins can see the users overview', function () {
    $this->loginAsAdmin();

    assertCanSeeTheUserOverview();
});

test('moderators can see the users overview', function () {
    $this->loginAsModerator();

    assertCanSeeTheUserOverview();
});

test('admins can ban a user', function () {
    $this->loginAsAdmin();

    assertCanBanUsers();
});

test('moderators can ban a user', function () {
    $this->loginAsModerator();

    assertCanBanUsers();
});

test('admins can unban a user', function () {
    $this->loginAsAdmin();

    assertCanUnbanUsers();
});

test('moderators can unban a user', function () {
    $this->loginAsModerator();

    assertCanUnbanUsers();
});

test('admins cannot ban other admins', function () {
    $this->loginAsAdmin();

    assertCannotBanAdmins();
});

test('moderators cannot ban admins', function () {
    $this->loginAsModerator();

    assertCannotBanAdmins();
});

test('moderators cannot ban other moderators', function () {
    $this->loginAsModerator();

    assertCannotBanModerators();
});

test('admins can delete a user', function () {
    $user = User::factory()->create(['name' => 'Freek Murze']);
    $thread = Thread::factory()->create(['author_id' => $user->id()]);
    Reply::factory()->create(['replyable_id' => $thread->id()]);
    Reply::factory()->create(['author_id' => $user->id()]);

    $this->loginAsAdmin();

    $this->delete('/admin/users/'.$user->username())
        ->assertRedirectedTo('/admin');

    $this->notSeeInDatabase('users', ['name' => 'Freek Murze']);

    // Make sure associated content is deleted.
    $this->notSeeInDatabase('threads', ['author_id' => $user->id()]);
    $this->notSeeInDatabase('replies', ['replyable_id' => $thread->id()]);
    $this->notSeeInDatabase('replies', ['author_id' => $user->id()]);
});

test('admins cannot delete other admins', function () {
    $user = User::factory()->create(['type' => User::ADMIN]);

    $this->loginAsAdmin();

    $this->delete('/admin/users/'.$user->username())
        ->assertForbidden();
});

test('moderators cannot delete users', function () {
    $user = User::factory()->create();

    $this->loginAsModerator();

    $this->delete('/admin/users/'.$user->username())
        ->assertForbidden();
});

test('admins can list submitted articles', function () {
    $submittedArticle = Article::factory()->create(['submitted_at' => now()]);
    $draftArticle = Article::factory()->create();
    $liveArticle = Article::factory()->create(['submitted_at' => now(), 'approved_at' => now()]);

    $this->loginAsAdmin();

    $this->get('admin')
        ->see($submittedArticle->title())
        ->dontSee($draftArticle->title())
        ->dontSee($liveArticle->title());
});

test('moderators can list submitted articles', function () {
    $submittedArticle = Article::factory()->create(['submitted_at' => now()]);
    $draftArticle = Article::factory()->create();
    $liveArticle = Article::factory()->create(['submitted_at' => now(), 'approved_at' => now()]);

    $this->loginAsModerator();

    $this->get('admin')
        ->see($submittedArticle->title())
        ->dontSee($draftArticle->title())
        ->dontSee($liveArticle->title());
});

test('users cannot list submitted articles', function () {
    $this->login();

    $this->get('admin')
        ->assertForbidden();
});

test('guests cannot list submitted articles', function () {
    $this->get('admin')
        ->assertRedirectedTo('login');
});

test('admins can view submitted articles', function () {
    $article = Article::factory()->create(['submitted_at' => now()]);

    $this->loginAsAdmin();

    $this->get("articles/{$article->slug()}")
        ->see('Awaiting Approval');
});

test('admins can approve articles', function () {
    $article = Article::factory()->create(['submitted_at' => now()]);

    $this->loginAsAdmin();

    $this->put("/admin/articles/{$article->slug()}/approve");

    $this->assertNotNull($article->fresh()->approvedAt());
});

test('moderators can approve articles', function () {
    $article = Article::factory()->create(['submitted_at' => now()]);

    $this->loginAsModerator();

    $this->put("/admin/articles/{$article->slug()}/approve");

    $this->assertNotNull($article->fresh()->approvedAt());
});

test('users cannot approve articles', function () {
    $article = Article::factory()->create(['submitted_at' => now()]);

    $this->login();

    $this->put("/admin/articles/{$article->slug()}/approve")
        ->assertForbidden();
});

test('guests cannot approve articles', function () {
    $article = Article::factory()->create(['submitted_at' => now()]);

    $this->put("/admin/articles/{$article->slug()}/approve")
        ->assertRedirectedTo('/login');

    expect($article->fresh()->approvedAt())->toBeNull();
});

test('admins can disapprove articles', function () {
    $article = Article::factory()->create(['submitted_at' => now(), 'approved_at' => now()]);

    $this->loginAsAdmin();

    $this->put("/admin/articles/{$article->slug()}/disapprove");

    expect($article->fresh()->approvedAt())->toBeNull();
});

test('moderators can disapprove articles', function () {
    $article = Article::factory()->create(['submitted_at' => now(), 'approved_at' => now()]);

    $this->loginAsModerator();

    $this->put("/admin/articles/{$article->slug()}/disapprove");

    expect($article->fresh()->approvedAt())->toBeNull();
});

test('users cannot disapprove articles', function () {
    $article = Article::factory()->create(['submitted_at' => now(), 'approved_at' => now()]);

    $this->login();

    $this->put("/admin/articles/{$article->slug()}/disapprove")
        ->assertForbidden();
});

test('guests cannot disapprove articles', function () {
    $article = Article::factory()->create(['submitted_at' => now(), 'approved_at' => now()]);

    $this->put("/admin/articles/{$article->slug()}/disapprove")
        ->assertRedirectedTo('/login');

    $this->assertNotNull($article->fresh()->approvedAt());
});

test('admins can pin articles', function () {
    $article = Article::factory()->create(['submitted_at' => now(), 'approved_at' => now()]);

    $this->loginAsAdmin();

    $this->put("/admin/articles/{$article->slug()}/pinned");

    expect($article->fresh()->isPinned())->toBeTrue();
});

test('moderators can pin articles', function () {
    $article = Article::factory()->create(['submitted_at' => now(), 'approved_at' => now()]);

    $this->loginAsModerator();

    $this->put("/admin/articles/{$article->slug()}/pinned");

    expect($article->fresh()->isPinned())->toBeTrue();
});

test('users cannot pin articles', function () {
    $article = Article::factory()->create(['submitted_at' => now(), 'approved_at' => now()]);

    $this->login();

    $this->put("/admin/articles/{$article->slug()}/pinned");

    expect($article->fresh()->isPinned())->toBeFalse();
});

test('guests cannot pin articles', function () {
    $article = Article::factory()->create(['submitted_at' => now(), 'approved_at' => now()]);

    $this->put("/admin/articles/{$article->slug()}/pinned");

    expect($article->fresh()->isPinned())->toBeFalse();
});

test('admins can unpin articles', function () {
    $article = Article::factory()->create([
        'submitted_at' => now(),
        'approved_at' => now(),
        'is_pinned' => true,
    ]);

    $this->loginAsAdmin();

    $this->put("/admin/articles/{$article->slug()}/pinned");

    expect($article->fresh()->isPinned())->toBeFalse();
});

test('moderators can unpin articles', function () {
    $article = Article::factory()->create([
        'submitted_at' => now(),
        'approved_at' => now(),
        'is_pinned' => true,
    ]);

    $this->loginAsModerator();

    $this->put("/admin/articles/{$article->slug()}/pinned");

    expect($article->fresh()->isPinned())->toBeFalse();
});

test('users cannot unpin articles', function () {
    $article = Article::factory()->create([
        'submitted_at' => now(),
        'approved_at' => now(),
        'is_pinned' => true,
    ]);

    $this->login();

    $this->put("/admin/articles/{$article->slug()}/pinned");

    expect($article->fresh()->isPinned())->toBeTrue();
});

test('guests cannot unpin articles', function () {
    $article = Article::factory()->create([
        'submitted_at' => now(),
        'approved_at' => now(),
        'is_pinned' => true,
    ]);

    $this->put("/admin/articles/{$article->slug()}/pinned");

    expect($article->fresh()->isPinned())->toBeTrue();
});

// Helpers
function assertCanSeeTheUserOverview()
{
    User::factory()->create(['name' => 'Freek Murze']);
    User::factory()->create(['name' => 'Frederick Vanbrabant']);

    test()->visit('/admin/users')
        ->see('Freek Murze')
        ->see('Frederick Vanbrabant');
}

function assertCanBanUsers()
{
    $user = User::factory()->create(['name' => 'Freek Murze']);

    test()->put('/admin/users/'.$user->username().'/ban')
        ->assertRedirectedTo('/user/'.$user->username());

    test()->notSeeInDatabase('users', ['id' => $user->id(), 'banned_at' => null]);
}

function assertCanUnbanUsers()
{
    $user = User::factory()->create(['name' => 'Freek Murze', 'banned_at' => Carbon::now()]);

    test()->put('/admin/users/'.$user->username().'/unban')
        ->assertRedirectedTo('/user/'.$user->username());

    test()->seeInDatabase('users', ['id' => $user->id(), 'banned_at' => null]);
}

function assertCannotBanAdmins()
{
    assertCannotBanUsersByType(User::ADMIN);
}

function assertCannotBanModerators()
{
    assertCannotBanUsersByType(User::MODERATOR);
}

function assertCannotBanUsersByType(int $type)
{
    $user = User::factory()->create(['type' => $type]);

    test()->put('/admin/users/'.$user->username().'/ban')
        ->assertForbidden();
}
