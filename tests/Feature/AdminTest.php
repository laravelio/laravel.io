<?php

use App\Filament\Resources\Users\Pages\ListUsers;
use App\Models\Article;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Carbon\Carbon;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function Pest\Livewire\livewire;

uses(TestCase::class);
uses(RefreshDatabase::class);

test('requires login', function () {
    $this->get('/admin')
        ->assertRedirect('/admin/login');
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

test('admins can ban a user and delete their threads', function () {
    $this->loginAsAdmin();

    assertCanBanUsersAndDeleteThreads();
});

test('moderators can ban a user', function () {
    $this->loginAsModerator();

    assertCanBanUsers();
});

test('moderators can ban a user and delete their threads', function () {
    $this->loginAsModerator();

    assertCanBanUsersAndDeleteThreads();
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

test('admins cannot ban a user without a reason', function () {
    $user = User::factory()->create(['name' => 'Freek Murze']);

    $this->loginAsAdmin();

    $this->put('/admin/users/'.$user->username().'/ban')
        ->assertRedirect('/');

    test()->assertDatabaseHas('users', ['id' => $user->id(), 'banned_at' => null, 'banned_reason' => null]);
});

test('moderators cannot ban a user without a reason', function () {
    $user = User::factory()->create(['name' => 'Freek Murze']);

    $this->loginAsModerator();

    $this->put('/admin/users/'.$user->username().'/ban')
        ->assertRedirect('/');

    test()->assertDatabaseHas('users', ['id' => $user->id(), 'banned_at' => null, 'banned_reason' => null]);
});

test('admins can delete a user', function () {
    $user = User::factory()->create(['name' => 'Freek Murze']);
    $thread = Thread::factory()->create(['author_id' => $user->id()]);
    Reply::factory()->create(['replyable_id' => $thread->id()]);
    Reply::factory()->create(['author_id' => $user->id()]);

    $this->loginAsAdmin();

    livewire(ListUsers::class)
        ->callAction(TestAction::make('delete')->table($user));

    $this->assertDatabaseMissing('users', ['name' => 'Freek Murze']);
    $this->assertDatabaseMissing('threads', ['author_id' => $user->id()]);
    $this->assertDatabaseMissing('replies', ['replyable_id' => $thread->id()]);
    $this->assertDatabaseMissing('replies', ['author_id' => $user->id()]);
});

test('admins cannot delete other admins', function () {
    $user = User::factory()->create(['type' => User::ADMIN]);

    $this->loginAsAdmin();

    livewire(ListUsers::class)
        ->assertActionHidden(TestAction::make('delete')->table($user));
});

test('moderators cannot delete users', function () {
    $user = User::factory()->create();

    $this->loginAsModerator();

    livewire(ListUsers::class)
        ->assertActionHidden(TestAction::make('delete')->table($user));
});

test('admins can list submitted articles', function () {
    $submittedArticle = Article::factory()->create(['submitted_at' => now(), 'title' => 'My submitted article']);
    $draftArticle = Article::factory()->create(['title' => 'My draft article']);
    $liveArticle = Article::factory()->create(['submitted_at' => now(), 'approved_at' => now(), 'title' => 'My live article']);

    $this->loginAsAdmin();

    $this->get('admin/articles')
        ->assertSee($submittedArticle->title())
        ->assertDontSee($draftArticle->title())
        ->assertDontSee($liveArticle->title());
});

test('moderators can list submitted articles', function () {
    $submittedArticle = Article::factory()->create(['submitted_at' => now()]);
    $draftArticle = Article::factory()->create();
    $liveArticle = Article::factory()->create(['submitted_at' => now(), 'approved_at' => now()]);

    $this->loginAsModerator();

    $this->get('admin/articles')
        ->assertSee($submittedArticle->title())
        ->assertDontSee($draftArticle->title())
        ->assertDontSee($liveArticle->title());
});

test('users cannot list submitted articles', function () {
    $this->login();

    $this->get('admin')
        ->assertForbidden();
});

test('guests cannot list submitted articles', function () {
    $this->get('admin')
        ->assertRedirect('/admin/login');
});

test('admins can view submitted articles', function () {
    $article = Article::factory()->create(['submitted_at' => now()]);

    $this->loginAsAdmin();

    $this->get("articles/{$article->slug()}")
        ->assertSee('Awaiting Approval');
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
        ->assertRedirect('/login');

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
        ->assertRedirect('/login');

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

    test()->get('/admin/users')
        ->assertSee('Freek Murze')
        ->assertSee('Frederick Vanbrabant');
}

function assertCanBanUsers()
{
    $user = User::factory()->create(['name' => 'Freek Murze']);

    test()->put('/admin/users/'.$user->username().'/ban', ['reason' => 'A good reason', 'delete_threads' => false])
        ->assertRedirect('/user/'.$user->username());

    test()->assertDatabaseMissing('users', ['id' => $user->id(), 'banned_at' => null]);
    test()->assertDatabaseHas('users', ['id' => $user->id(), 'banned_reason' => 'A good reason']);
}

function assertCanBanUsersAndDeleteThreads()
{
    $user = User::factory()->create(['name' => 'Freek Murze']);

    test()->put('/admin/users/'.$user->username().'/ban', ['reason' => 'A good reason', 'delete_threads' => true])
        ->assertRedirect('/user/'.$user->username());

    test()->assertDatabaseMissing('users', ['id' => $user->id(), 'banned_at' => null]);
    test()->assertDatabaseHas('users', ['id' => $user->id(), 'banned_reason' => 'A good reason']);
    test()->assertDatabaseMissing('threads', ['author_id' => $user->id()]);
}

function assertCanUnbanUsers()
{
    $user = User::factory()->create(['name' => 'Freek Murze', 'banned_at' => Carbon::now()]);

    test()->put('/admin/users/'.$user->username().'/unban')
        ->assertRedirect('/user/'.$user->username());

    test()->assertDatabaseHas('users', ['id' => $user->id(), 'banned_at' => null, 'banned_reason' => null]);
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

    test()->put('/admin/users/'.$user->username().'/ban', ['reason' => 'A good reason', 'delete_threads' => fake()->boolean()])
        ->assertForbidden();
}
