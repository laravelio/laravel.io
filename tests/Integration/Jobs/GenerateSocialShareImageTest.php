<?php

use App\Jobs\GenerateSocialShareImage;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Pixelmatch\Pixelmatch;
use Tests\TestCase;

uses(TestCase::class);
uses(RefreshDatabase::class);

test('social image response contains a valid PNG', function () {
    $article = new Article(['title' => 'A social image with multiple lines of text']);

    $response = (new GenerateSocialShareImage($article))->handle();
    $image = getimagesizefromstring($response->getContent());
    $template = getimagesize(resource_path('images/'.GenerateSocialShareImage::TEMPLATE));

    expect($response->headers->get('Content-Type'))->toBe('image/png')
        ->and($response->headers->get('Cache-Control'))->toBe('max-age=86400, public')
        ->and($image[0])->toBe($template[0])
        ->and($image[1])->toBe($template[1])
        ->and($image[2])->toBe(IMAGETYPE_PNG);
});

test('social image is generated for articles', function () {
    $article = Article::factory()->create([
        'title' => 'This is an article to test social share image generation',
    ]);

    $generatedSocialShareImagePath = sys_get_temp_dir().'/generated_social_share_temporary_image.png';

    file_put_contents(
        $generatedSocialShareImagePath,
        ((new GenerateSocialShareImage($article))->handle())->content()
    );

    expect(
        Pixelmatch::new(
            $generatedSocialShareImagePath,
            base_path('tests/stubs/generate_social_share_image.png')
        )->matches()
    )->toBeTrue();

    unlink($generatedSocialShareImagePath);
})->skip('Fails on GitHub Actions');
