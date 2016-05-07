<?php
namespace Lio\Spam;

use Illuminate\Support\ServiceProvider;

class SpamServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SpamDetector::class, function () {
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
