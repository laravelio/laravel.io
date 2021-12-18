<?php

$githubUsername = is_array(session('githubData')) ? session('githubData')['username'] : '';

return [
    'banned' => 'This account is banned.',
    'fields' => 'Something went wrong. Please review the fields below.',
    'github_invalid_state' => 'The request timed out. Please try again.',
    'github_account_too_young' => 'Your Github account needs to be older than 2 weeks in order to register.',
    'github_account_exists' => 'We already found a user with the given GitHub account (https://github/'.$githubUsername ?? ''.'). Would you like to login instead?',

];
