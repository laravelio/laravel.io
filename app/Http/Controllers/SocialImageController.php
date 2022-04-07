<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateSocialShareImage;
use App\Models\Article;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class SocialImageController extends Controller
{
    public function __invoke(Article $article, )
    {
        $this->dispatchSync(new GenerateSocialShareImage($article, $uuid = Str::uuid()));

        $image = Cache::get($uuid);

        Cache::forget($uuid);

        return $image;
    }
}
