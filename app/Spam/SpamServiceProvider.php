<?php

namespace App\Spam;

use TijsVerkoyen\Akismet\Akismet;
use Illuminate\Support\ServiceProvider;

class SpamServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SpamDetector::class, function () {
            $detectors = [];

            if ($apiKey = config('services.akismet.api_key')) {
                $detectors[] = $this->akismetSpamDetector($apiKey);
            }

            return new SpamFilter(...$detectors);
        });
    }

    private function akismetSpamDetector($apiKey): AkismetSpamDetector
    {
        return new AkismetSpamDetector(new Akismet($apiKey, config('app.url')));
    }
}
