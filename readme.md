# Laravel.io Community Portal

<img src="https://travis-ci.org/LaravelIO/laravel.io.svg?branch=master" alt="Build Status">
<img src="https://scrutinizer-ci.com/g/LaravelIO/laravel.io/badges/quality-score.png?b=master" alt="Scrutinizer Code Quality">
<img src='https://coveralls.io/repos/LaravelIO/laravel.io/badge.png?branch=master' alt='Coverage Status' />
<img src="https://insight.sensiolabs.com/projects/50a7431f-66b0-4221-8837-7ccf1924031e/mini.png" alt="SensioLabsInsight">

This is the repository for the [Laravel.io](http://laravel.io) community portal. The code is entirely open source and licensed under [the MIT license](license.txt). Feel free to contribute to the portal by sending in a pull request.

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

1. Clone this repository: `git clone git@github.com:laravelio/laravel-io.git laravelio/`
2. Update your `Homestead.yml` with the following settings:
    1. Add the path for the cloned laravel.io repository to the `folders` list
    2. Add a site `lio.loc` for the laravel.io repository to the `sites` list
    3. Add a database called `laravelio` to the `databases` list
    4. Run `homestead provision`
3. SSH into your Homestead box and run the following commands:
    1. `composer install`
    2. `php artisan migrate --seed --env=local`
4. Add `192.168.10.10 lio.loc` to your computer's `hosts` file
5. Follow the configuration steps below to configure the external services

## Configuration

Laravel.io relies on some key services to function, namely Github OAuth authentication and the Google ReCaptcha service. Follow the steps below to fill in the credentials in your custom `.env` file.

1. [Create an application](https://github.com/settings/applications) in your github account called something like "Laravel.io Development" and add your Github application's client id, secret and url to the `.env` file. Your GitHub application should be set up as follows.

    Full URL: http://lio.loc  
    Callback URL: http://lio.loc/auth/github

2. [Register a new website](https://www.google.com/recaptcha/admin) for the Google ReCaptcha service and fill in the site key and secret key in the `.env` file.

You can now visit the app in your browser by visiting [http://lio.loc/](http://lio.loc).

## Frontend

Because we keep the generated / minified css out of the repository, we must have a workflow for compiling the styles.

- To compile stylesheets, we'll need [Compass](http://compass-style.org/). Install Compass by running `sudo apt-get install ruby-compass` when ssh'd into your Homestead box.
- When running any Compass command in the terminal, be sure to run it from your `/public` folder.
- Compass is the tool used to compile Sass source files into CSS files; you can run `compass compile` to run it once, or `compass watch` to trigger a script that will watch your Sass files for changes and trigger a new compass compile on each change

## Maintainers

The Laravel.io portal is currently maintained by [Dries Vints](https://github.com/driesvints). If you have any questions please don't hesitate to contact us through the support widget on the [Laravel.io](http://laravel.io/) website.

## Contributing

Please see [the contributing guide](contributing.md) for details.

## Security Vulnerabilities

If you discover a security vulnerability within Laravel.io, please send an email immediately to Dries Vints at [dries.vints@gmail.com](mailto:dries.vints@gmail.com). **Do not create an issue for the vulnerability.**

## License

The MIT License. Please see [the license file](license.txt) for more information.
