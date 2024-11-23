<?php

use App\Jobs\GenerateSocialShareImage;
use App\Models\Article;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

uses(TestCase::class);
uses(DatabaseMigrations::class);

test('social image is generated for articles', function () {
    $article = Article::factory()->create([
        'title' => 'This is an article to test social share image generation'
    ]);

    $generatedSocialShareImagePath = sys_get_temp_dir() . '/generated_social_share_temporary_image.png';

    file_put_contents(
        $generatedSocialShareImagePath,
        ((new GenerateSocialShareImage($article))->handle())->content()
    );

    expect(
        hash_file(
            'sha256',
            $generatedSocialShareImagePath
        )
    )->toBe(
        hash_file(
            'sha256',
            $this->getStub('generate_social_share_image.png')
        )
    );

    unlink($generatedSocialShareImagePath);
});
