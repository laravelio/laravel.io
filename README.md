# Laravel.io Community Portal


[![Github Actions](https://github.com/laravelio/portal/workflows/tests/badge.svg)](https://github.com/laravelio/portal/actions)
[![StyleCI](https://styleci.io/repos/12895187/shield?branch=master)](https://styleci.io/repos/12895187)
[![Laravel Version](https://shield.with.social/cc/github/laravelio/portal/master.svg?style=flat-square)](https://packagist.org/packages/laravel/framework)

This is the repository for the [Laravel.io](http://laravel.io) community portal. The code is entirely open source and
licensed under [the MIT license](LICENSE.md). We welcome your contributions but we encourage you to read the
[the contributing guide](CONTRIBUTING.md) before creating an issue or sending in a pull request. Read the installation
guide below to get started with setting up the app on your machine.

We hope to see your contribution soon!

## Requirements

The following tools are required in order to start the installation.

- [Composer](https://getcomposer.org/download/)
- [NPM](https://docs.npmjs.com/downloading-and-installing-node-js-and-npm)
- [Valet](https://laravel.com/docs/valet#installation)
- PHP >=7.3

## Installation

> Note that you're free to adjust the `~/Sites/laravel.io` location to any directory you want on your machine. In doing so, be sure to run the `valet link` command inside the desired directory.

1. Clone this repository with `git clone git@github.com:laravelio/portal.git ~/Sites/laravel.io`
2. Run `composer install` to install the PHP dependencies
3. Setup a local database called `laravelio`
4. Run `composer setup` to setup the application
5. Setup a working e-mail driver like [Mailtrap](https://mailtrap.io/)
6. (optional) Set up Github authentication (see below)

You can now visit the app in your browser by visiting [http://laravel.io.test](http://laravel.io.test). If you seeded the
database you can login into a test account with **`johndoe`** & **`password`**.

### Github Authentication (optional)

To get Github authentication to work locally, you'll need to
[register a new OAuth application on Github](https://github.com/settings/applications/new). Use `http://laravel.io.test`
for the homepage url and `http://laravel.io.test/auth/github` for the callback url. When you've created the app, fill in
the ID and secret in your `.env` file in the env variables below. You should now be able to authentication with Github.

```
GITHUB_ID=
GITHUB_SECRET=
GITHUB_URL=http://laravel.io.test/auth/github
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
