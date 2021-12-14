<?php

namespace App\Jobs;

use App\Models\Article;
use Intervention\Image\ImageManager;

final class GenerateSocialShareImage
{
    const TEXT_X_POSITION = 50;

    const TEXT_Y_POSITION = 100;

    const TEXT_COLOUR = '#161e2e';

    const FONT = 'inter.ttf';

    const FONT_SIZE = 50;

    const CHARACTERS_PER_LINE = 30;

    const TEMPLATE = 'social-share-template.png';

    const CACHE_LIFETIME = 43200;

    public function __construct(
        private Article $article
    ) {
    }

    public function handle(ImageManager $image)
    {
        $text = wordwrap($this->article->title(), self::CHARACTERS_PER_LINE);

        return $image->cache(function ($image) use ($text) {
            $image->make(resource_path('images/'.self::TEMPLATE))
                ->text($text, self::TEXT_X_POSITION, self::TEXT_Y_POSITION, function ($font) {
                    $font->file(resource_path('fonts/'.self::FONT));
                    $font->size(self::FONT_SIZE);
                    $font->color(self::TEXT_COLOUR);
                });
        }, self::CACHE_LIFETIME, true)->response('png');
    }
}
