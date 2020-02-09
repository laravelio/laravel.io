# Laravel.io Community Portal

[![CircleCI](https://img.shields.io/circleci/build/github/laravelio/portal/master)](https://circleci.com/gh/laravelio/portal/tree/master)
[![StyleCI](https://styleci.io/repos/12895187/shield?branch=master)](https://styleci.io/repos/12895187)
[![Laravel Version](https://shield.with.social/cc/github/laravelio/portal/master.svg?style=flat-square)](https://packagist.org/packages/laravel/framework)

This is the repository for the [Laravel.io](http://laravel.io) community portal. The code is entirely open source and
licensed under [the MIT license](LICENSE.md). We welcome your contributions but we encourage you to read the
[the contributing guide](CONTRIBUTING.md) before creating an issue or sending in a pull request. Read the installation
guide below to get started with setting up the app on your machine.

We hope to see your contribution soon!

## Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Maintainers](#maintainers)
- [Contributing](#contributing)
- [Code of Conduct](#code-of-conduct)
- [Security Vulnerabilities](#security-vulnerabilities)
- [License](#license)

## Requirements

The following tools are required in order to start the installation.

- [VirtualBox](https://www.virtualbox.org/)
- [Vagrant](https://www.vagrantup.com/)
- [Composer](https://getcomposer.org/download/)
- PHP >=7.1

## Installation

> Note that you're free to adjust the `~/Sites/laravelio` location to any directory you want on your machine. In doing so, be sure to run the `valet park` command inside the desired directory.

1. Install Laravel Valet as per the [installation instructions](https://laravel.com/docs/valet#installation)
2. Clone this repository: `git clone git@github.com:laravelio/laravel-io.git ~/Sites/laravelio`
3. Run `composer install`
4. Copy the `.env.example` to a file called `.env` in the same directory
5. Run `php artisan key:generate` to set the application key
6. Setup a database for the app in your development environment and update the database credentials in the `.env` file accordingly
7. run `php artisan migrate --seed`
8. Setup a working e-mail driver like [Mailtrap](https://mailtrap.io/)
9. (optional) Set up Github authentication (see below)

You can now visit the app in your browser by visiting [http://laravelio.test](http://laravelio.test). If you seeded the
database you can login into a test account with `johndoe` & `password`.

### Github Authentication (optional)

To get Github authentication to work locally, you'll need to
[register a new OAuth application on Github](https://github.com/settings/applications/new). Use `http://laravelio.test`
for the homepage url and `http://laravelio.test/auth/github` for the callback url. When you've created the app, fill in
the ID and secret in your `.env` file in the env variables below. You should now be able to authentication with Github.

```
GITHUB_ID=
GITHUB_SECRET=
GITHUB_URL=http://laravelio.test/auth/github
```

## Maintainers

The Laravel.io portal is currently maintained by [Dries Vints](https://github.com/driesvints) and [Joe Dixon](https://github.com/joedixon). If you have any questions
please don't hesitate to create an issue on this repo.

## Contributing

Please read [the contributing guide](CONTRIBUTING.md) before creating an issue or sending in a pull request.

## Code of Conduct

Please read our [Code of Conduct](CODE_OF_CONDUCT.md) before contributing or engaging in discussions.

## Security Vulnerabilities

If you discover a security vulnerability within Laravel.io, please send an email immediately to Dries Vints at
[dries.vints@gmail.com](mailto:dries.vints@gmail.com). **Do not create an issue for the vulnerability.**

## License

The MIT License. Please see [the license file](LICENSE.md) for more information.
