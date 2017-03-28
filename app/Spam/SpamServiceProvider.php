<?php

namespace App\Spam;

use Illuminate\Support\ServiceProvider;
use TijsVerkoyen\Akismet\Akismet;

class SpamServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SpamDetector::class, function () {
            $detectors = [
                new PhoneNumberSpamDetector,
                new ForeignLanguageSpamDetector,
            ];

            if ($apiKey = config('services.akismet.api_key')) {
                $detectors[] = $this->akismetSpamDetector($apiKey);
            }

            return new SpamFilter($detectors);
        });
    }

    private function akismetSpamDetector($apiKey): AkismetSpamDetector
    {
        return new AkismetSpamDetector(new Akismet($apiKey, config('app.url')));
    }
}
