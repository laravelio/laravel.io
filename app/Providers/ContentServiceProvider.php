<?php
namespace Lio\Providers;

use Illuminate\Support\ServiceProvider;
use Lio\Content\ForeignLanguageSpamDetector;
use Lio\Content\PhoneNumberSpamDetector;
use Lio\Content\SpamDetector;
use Lio\Content\SpamFilter;

class ContentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bindShared(SpamDetector::class, function () {
            return new SpamFilter([
                new PhoneNumberSpamDetector,
                new ForeignLanguageSpamDetector,
            ]);
        });
    }

    public function provides()
    {
        return [SpamDetector::class];
    }
}
