<?php

return [
    /**
     * Set your Bugsnag API Key.
     * You can find your API Key on your Bugsnag dashboard.
     */
    'api_key' => getenv('BUGSNAG_API_KEY') ?: '',

    /**
     * Set which release stages should send notifications to Bugsnag
     * E.g: array('development', 'production')
     */
    'notify_release_stages' => ['production'],
];
