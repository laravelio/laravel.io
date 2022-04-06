<?php

namespace App\Http\Controllers;

use App\Actions\GenerateSocialShareImage;
use App\Models\Article;

class SocialImageController extends Controller
{
    public function __invoke(Article $article, GenerateSocialShareImage $image)
    {
        return $image->generate($article);
    }
}
