# Laravel.IO Community Portal

<img src="https://travis-ci.org/LaravelIO/laravel.io.svg?branch=master" alt="Build Status">
<img src="https://scrutinizer-ci.com/g/LaravelIO/laravel.io/badges/quality-score.png?b=master" alt="Scrutinizer Code Quality">
<img src='https://coveralls.io/repos/LaravelIO/laravel.io/badge.png?branch=master' alt='Coverage Status' />
<img src="https://insight.sensiolabs.com/projects/50a7431f-66b0-4221-8837-7ccf1924031e/mini.png" alt="SensioLabsInsight">

This is the Laravel.IO community portal site. The site is entirely open source and community involvement is not only encouraged, but required in order to ensure the future success of the project.

## Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Frontend](#frontend)
- [Maintainers](#maintainers)
- [Contributing](#contributing)
- [Security Vulnerabilities](#security-vulnerabilities)
- [License](#license)

## Requirements

We use Laravel Homestead for local development. Please review [the Homestead documentation](http://laravel.com/docs/homestead) to install it.

In order to compile stylesheets you will also need Ruby, Sass, and Compass installed.

## Installation

Here are the steps for installation on a local machine.

1. Make sure you have [Laravel Homestead](http://laravel.com/docs/homestead) installed
2. Clone this repository: `git clone git@github.com:LaravelIO/laravel-io.git laravelio/`
3. Add the path for the cloned laravel.io repository to the `Homestead.yml` file under the `folders` list
4. Add a site `lio.loc` for the laravel.io repository to the `Homestead.yml` file under the `sites` list
5. Run `vagrant provision` in your Homestead folder
6. Create a database in Homestead called `laravelio`
7. Run `composer install` and `php artisan migrate --seed --env=local`
8. Add `192.168.10.10 lio.loc` to your computer's `hosts` file
9. Follow the configuration steps below to configure the external services

## Configuration

Laravel.IO relies on some key services to function, namely Github OAuth authentication and the Google ReCaptcha service. Follow the steps below to fill in the credentials in a custom `.env.local.php` file.

1. Create the configuration file below at the root of your application with the name ***.env***.

```
GITHUB_CLIENT_ID=
GITHUB_CLIENT_SECRET=
GOOGLE_RECAPTCHA_SITEKEY=
GOOGLE_RECAPTCHA_SECRETKEY=
```

2. [Create an application](https://github.com/settings/applications) in your github account called something like "Laravel IO Development" and add your Github application's client id and secret to the `.env.local.php` file. Your GitHub application should be set up as follows.

    a. Full URL: http://lio.loc
    b. Callback URL: http://lio.loc/login

3. [Register a new website](https://www.google.com/recaptcha/admin) for the Google ReCaptcha service and fill in the site key and secret key in the `.env.local.php` file.

You can now visit the app in your browser by visiting [http://lio.loc/](http://lio.loc).

## Frontend

Because we keep the generated / minified css out of the repository, we must have a workflow for compiling the styles.

- Be sure you have Ruby, Sass, and Compass installed on your machine
- When running any compass command in the terminal, be sure to run it from your `/public` folder.
- Compass is the tool used to compile Sass source files into CSS files; you can run `compass compile` to run it once, or `compass watch` to trigger a script that will watch your Sass files for changes and trigger a new compass compile on each change

## Maintainers

The Laravel.IO portal is currently maintained by [Dries Vints](https://github.com/driesvints). If you have any questions please don't hesitate to contact us through the support widget on the [Laravel.IO](http://laravel.io/) website.

## Contributing

Please see [the contributing guide](contributing.md) for details.

## Security Vulnerabilities

If you discover a security vulnerability within Laravel.IO, please send an email immediately to Dries Vints at dries.vints@gmail.com. **Do not create an issue for the vulnerability.**

## License

The MIT License. Please see [the license file](license.txt) for more information.
