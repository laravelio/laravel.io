<?php

return [
    'setup' => [
        'signing_key' => 'Generate signing key',
        'write_env' => 'Write configuration to the .env file',
        'write_env_example' => 'Write configuration to the .env.example file',
        'publish_config' => 'Publish config file',
    ],

    'could_not_ping' => 'Could not send ping to :url [:status]. :body',

    'missing_base_url' => 'Could not send ping beause the thenping.me base URL is not set',

    'missing_endpoint_url' => 'Could not send ping because the endpoint URL is not set',

    'missing_signing_secret' => 'Could not send ping because the signing secret is not set',

    'invalid_signer' => ':concrete does not implement :contract',

    'env_missing' => 'The .env file is missing. Please add the following lines to your configuration, then run:',

    'signing_key_environment' => 'The .env file is missing. Please add the following lines to your configuration',

    'initial_setup' => 'Setting up initial tasks with :url',

    'syncing_tasks' => 'Syncing your scheduled tasks with :url',

    'healthy_tasks' => 'Your tasks are correctly configured and can be synced to thenping.me!',

    'successful_sync' => 'Your tasks have been synced with thenping.me!',

    'indistinguishable_tasks' => 'Tasks have been identified that are not uniquely distinguishable!',

    'duplicate_jobs' => 'Job-based tasks should set a description, or run on a unique schedule.',
    'duplicate_closures' => 'Closure-based tasks should set a description to ensure uniqueness.',
];
