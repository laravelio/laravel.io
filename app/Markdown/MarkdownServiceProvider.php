<?php

namespace App\Markdown;

use Illuminate\Support\ServiceProvider;
use League\CommonMark\CommonMarkConverter;

class MarkdownServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Converter::class, function () {
            return new LeagueConverter(new CommonMarkConverter(['html_input' => 'escape']));
        });
    }
}
