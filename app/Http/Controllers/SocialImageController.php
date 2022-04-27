<?php

namespace App\Http\Controllers;

use App\Actions\GenerateSocialShareImage;
use App\Models\Article;

class SocialImageController extends Controller
{
    public function __invoke(GenerateSocialShareImage $generateImage, Article $article)
    {
        return $generateImage($article);
    }
}
