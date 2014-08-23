# Laravel.IO Community Portal

This is the Laravel.IO community portal site. The site is entirely open source and community involvement is not only encouraged, but required in order to ensure the future success of the project.

<table>
    <thead>
        <tr>
            <th>Branch</th>
            <th>master</th>
            <th>develop</th>
            <th>release/3.0</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Build Status</td>
            <td><a href="https://travis-ci.org/LaravelIO/laravel.io"><img src="https://travis-ci.org/LaravelIO/laravel.io.svg?branch=master" alt="Build Status"></a></td>
            <td><a href="https://travis-ci.org/LaravelIO/laravel.io"><img src="https://travis-ci.org/LaravelIO/laravel.io.svg?branch=develop" alt="Build Status"></a></td>
            <td><a href="https://travis-ci.org/LaravelIO/laravel.io"><img src="https://travis-ci.org/LaravelIO/laravel.io.svg?branch=release%23.0" alt="Build Status"></a></td>
        </tr>
        <tr>
            <td>Code Quality</td>
            <td><a href="https://scrutinizer-ci.com/g/LaravelIO/laravel.io/?branch=master"><img src="https://scrutinizer-ci.com/g/LaravelIO/laravel.io/badges/quality-score.png?b=master" alt="Scrutinizer Code Quality"></a></td>
            <td><a href="https://scrutinizer-ci.com/g/LaravelIO/laravel.io/?branch=develop"><img src="https://scrutinizer-ci.com/g/LaravelIO/laravel.io/badges/quality-score.png?b=develop" alt="Scrutinizer Code Quality"></a></td>
            <td><a href="https://scrutinizer-ci.com/g/LaravelIO/laravel.io/?branch=release%23.0"><img src="https://scrutinizer-ci.com/g/LaravelIO/laravel.io/badges/quality-score.png?b=release%23.0" alt="Scrutinizer Code Quality"></a></td>
        </tr>
        <tr>
            <td>Insights</td>
            <td><a href="https://insight.sensiolabs.com/projects/50a7431f-66b0-4221-8837-7ccf1924031e"><img src="https://insight.sensiolabs.com/projects/50a7431f-66b0-4221-8837-7ccf1924031e/mini.png" alt="SensioLabsInsight"></a></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table>


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

- Be sure you have Ruby, Sass, and Compass installed on your machine
- When running any compass command in the terminal, be sure to run it from your `/public` folder.
- Compass is the tool used to compile Sass source files into CSS files; you can run `compass compile` to run it once, or `compass watch` to trigger a script that will watch your Sass files for changes and trigger a new compass compile on each change

## Maintainer

The Laravel.IO project is currently maintained by [Dries Vints](https://github.com/driesvints). If you have any questions please don't hesitate to ask them in an issue or email me at [dries.vints@gmail.com](mailto:dries.vints@gmail.com).

## Testing

All tests can be run with the following command. Make sure to run this inside the Homestead box.

    $ vendor/bin/phpunit

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
