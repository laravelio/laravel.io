<?php

namespace App\Markdown;

use Illuminate\Support\ServiceProvider;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\Embed\Bridge\OscaroteroEmbedAdapter;
use League\CommonMark\Extension\Embed\EmbedExtension;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\Extension\Mention\MentionExtension;
use League\CommonMark\MarkdownConverter;

class MarkdownServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Converter::class, function ($app, array $params = []) {
            $environment = new Environment([
                'html_input' => 'escape',
                'max_nesting_level' => 10,
                'allow_unsafe_links' => false,
                'mentions' => [
                    'username' => [
                        'prefix' => '@',
                        'pattern' => '[a-z\d](?:[a-z\d]|-(?=[a-z\d])){0,38}(?!\w)',
                        'generator' => config('app.url').'/user/%s',
                    ],
                ],
                'external_link' => [
                    'internal_hosts' => config('app.host'),
                    'open_in_new_window' => true,
                    'nofollow' => ($params['nofollow'] ?? true) ? 'external' : '',
                ],
                'embed' => [
                    'adapter' => new OscaroteroEmbedAdapter,
                    'allowed_domains' => ['youtube.com'],
                    'fallback' => 'link',
                ],
            ]);

            $environment->addExtension(new CommonMarkCoreExtension);
            $environment->addExtension(new GithubFlavoredMarkdownExtension);
            $environment->addExtension(new MentionExtension);
            $environment->addExtension(new ExternalLinkExtension);
            $environment->addExtension(new EmbedExtension);

            return new LeagueConverter(new MarkdownConverter($environment));
        });
    }
}
