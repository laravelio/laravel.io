<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

uses(TestCase::class);

test('backup cleanup retains seven days and leaves other backup directories untouched', function () {
    $this->travelTo(now()->startOfSecond());
    $disk = Storage::fake('backups');
    Mail::fake();

    $newest = 'database/'.now()->format('Y-m-d-H-i-s').'.zip';
    $retained = 'database/'.now()->subDays(7)->addSecond()->format('Y-m-d-H-i-s').'.zip';
    $expired = 'database/'.now()->subDays(7)->subSecond()->format('Y-m-d-H-i-s').'.zip';
    $unrelated = 'another-site/'.now()->subDays(30)->format('Y-m-d-H-i-s').'.zip';

    foreach ([$newest, $retained, $expired, $unrelated] as $path) {
        $disk->put($path, 'archive');
    }

    $this->artisan('backup:clean')->assertSuccessful();

    $disk->assertExists([$newest, $retained, $unrelated]);
    $disk->assertMissing($expired);
    Mail::assertNothingSent();
});

test('backup monitoring fails for missing or stale backups without sending emails', function () {
    $this->travelTo(now()->startOfSecond());
    $disk = Storage::fake('backups');
    Mail::fake();

    $this->artisan('backup:monitor')->assertFailed();

    $disk->put('database/'.now()->subHours(23)->format('Y-m-d-H-i-s').'.zip', 'archive');

    $this->artisan('backup:monitor')->assertSuccessful();

    $this->travel(2)->hours();

    $this->artisan('backup:monitor')->assertFailed();
    Mail::assertNothingSent();
});
