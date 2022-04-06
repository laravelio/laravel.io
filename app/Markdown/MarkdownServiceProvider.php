<?php

namespace App\Markdown;

use Illuminate\Support\ServiceProvider;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\Mention\MentionExtension;
use League\CommonMark\MarkdownConverter;

class MarkdownServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Converter::class, function () {
            $environment = new Environment([
                'html_input' => 'escape',
                'mentions' => [
                    'username' => [
                        'prefix' => '@',
                        'pattern' => '[a-z\d](?:[a-z\d]|-(?=[a-z\d])){0,38}(?!\w)',
                        'generator' => config('app.url').'/user/%s',
                    ],
                ],
            ]);

            $environment->addExtension(new CommonMarkCoreExtension);
            $environment->addExtension(new MentionExtension);

            return new LeagueConverter(new MarkdownConverter($environment));
        });
    }
}
