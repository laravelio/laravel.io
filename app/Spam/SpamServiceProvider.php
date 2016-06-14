<?php
namespace Lio\Spam;

use Illuminate\Support\ServiceProvider;
use TijsVerkoyen\Akismet\Akismet;

class SpamServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(AkismetSpamDetector::class, function ($app) {
            $config = $app['config'];
            $apiKey = $config['services']['akismet']['api_key'];
            $url = $config['app']['url'];

            return new AkismetSpamDetector(new Akismet($apiKey, $url));
        });

        $this->app->singleton(SpamDetector::class, function ($app) {
            return new SpamFilter([
                new PhoneNumberSpamDetector,
                new ForeignLanguageSpamDetector,
                $app[AkismetSpamDetector::class]
            ]);
        });
    }

    public function provides()
    {
        return [AkismetSpamDetector::class, SpamDetector::class];
    }
}
