# Laravel.IO Community Portal

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/50a7431f-66b0-4221-8837-7ccf1924031e/mini.png)](https://insight.sensiolabs.com/projects/50a7431f-66b0-4221-8837-7ccf1924031e)

This is the Laravel.IO community portal site. The site is entirely open source and community involvement is not only encouraged, but required in order to ensure the future success of the project.

## Requirements

We use Laravel Homestead for local development. Please review [the Homestead documentation](http://laravel.com/docs/homestead) to install it.

In order to compile stylesheets you will also need Ruby, Sass, and Compass installed.

## Local Installation

Here are the steps for installation on a local machine.

1. Make sure you have [Laravel Homestead](http://laravel.com/docs/homestead) installed.
2. Clone this repository.

    ```
    git clone git@github.com:LaravelIO/laravel-io.git laravelio/
    cd laravelio/
    ```

3. Add the path for the cloned laravel.io repository to the `Homestead.yml` file under the `folders` list.
4. Add a site `lio.loc` for the laravel.io repository to the `Homestead.yml` file under the `sites` list.
5. Run `vagrant provision` in your Homestead folder.
6. Create a database in Homestead called `laravelio`.
7. SSH into your Homestead box, go to the laravel.io folder and run `./update_environment.sh`.
8. Add `127.0.0.1 lio.loc` to your computer's `hosts` file.

You can now visit the app in your browser by visiting [http://lio.loc:8000/](http://lio.loc:8000).

## Github OAuth Configuration

Now, we must install the oauth configuration.

1. [Create an application](https://github.com/settings/applications) in your github account called something like "Laravel IO Development" and add your GH application's client id and secret to this config file. Your GitHub Application should be set up as follows:

    a. Full URL: http://lio.loc:8000  
    b. Callback URL: http://lio.loc:8000/login

2. Create the configuration file below at ***app/config/packages/artdarek/oauth-4-laravel/config.php***

```PHP
<?php

return [
    'storage' => 'Session',

    'consumers' => [
        'GitHub' => [
            'client_id'     => 'YOUR_NEW_CLIENT_ID_HERE',
            'client_secret' => 'YOUR_NEW_CLIENT_SECRET_HERE',
            'scope'         => ['user'],
        ],
    ],
];
```

## Frontend

Because we keep the generated / minified css out of the repository, we must have a workflow for compiling the styles.

* Be sure you have Ruby, Sass, and Compass installed on your machine
* When running any compass command in the terminal, be sure to run it from your `/public` folder.
* Compass is the tool used to compile Sass source files into CSS files; you can run `compass compile` to run it once, or `compass watch` to trigger a script that will watch your Sass files for changes and trigger a new compass compile on each change

## Contribution

Please post proposals in the Github issues before coding up a PR.
