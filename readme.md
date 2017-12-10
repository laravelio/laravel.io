# Laravel.io Community Portal

[![Laravel Version](https://shield.with.social/cc/github/laravelio/portal/master.svg?style=flat-square)](https://packagist.org/packages/laravel/framework)
[![Build Status](https://travis-ci.org/laravelio/portal.svg?branch=master)](https://travis-ci.org/laravelio/portal)
[![StyleCI](https://styleci.io/repos/12895187/shield?branch=master)](https://styleci.io/repos/12895187)
[![Code Climate](https://codeclimate.com/github/LaravelIO/laravel.io/badges/gpa.svg)](https://codeclimate.com/github/laravelio/portal)
[![Test Coverage](https://codeclimate.com/github/LaravelIO/laravel.io/badges/coverage.svg)](https://codeclimate.com/github/laravelio/portal/coverage)
[![Dependency Status](https://dependencyci.com/github/laravelio/portal/badge)](https://dependencyci.com/github/laravelio/portal)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](license.txt)

This is the repository for the [Laravel.io](http://laravel.io) community portal. The code is entirely open source and licensed under [the MIT license](license.txt). We welcome your contributions but we encourage you to read the [the contributing guide](contributing.md) before creating an issue or sending in a pull request. Read the installation guide below to get started with setting up the app on your machine.

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

## Installation

> Note that you're free to adjust the `~/Sites/laravelio` location to any directory you want on your machine.

1. Clone this repository: `git clone git@github.com:laravelio/laravel-io.git ~/Sites/laravelio`
2. Run `composer start`
4. Run `vagrant up`
5. SSH into your Vagrant box, go to `/home/vagrant/Code/laravelio` and run `composer setup`
6. Add `192.168.10.10 laravelio.test` to your computer's `/etc/hosts` file
7. Setup a working e-mail driver like [Mailtrap](https://mailtrap.io/)
8. (optional) Set up Github authentication (see below)

You can now visit the app in your browser by visiting [http://laravelio.test](http://laravelio.test). If you seeded the database you can login into a test account with `johndoe` & `password`.

### Github Authentication (optional)

To get Github authentication to work locally, you'll need to [register a new OAuth application on Github](https://github.com/settings/applications/new). Use `http://laravelio.test` for the homepage url and `http://laravelio.test/auth/github` for the callback url. When you've created the app, fill in the ID and secret in your `.env` file in the env variables below. You should now be able to authentication with Github.

```
GITHUB_ID=
GITHUB_SECRET=
GITHUB_URL=http://laravelio.test/auth/github
```

## Maintainers

The Laravel.io portal is currently maintained by [Dries Vints](https://github.com/driesvints). If you have any questions please don't hesitate to create an issue on this repo or ask us through the #laravelio channel on [Slack](https://larachat.slack.com).

## Contributing

Please read [the contributing guide](contributing.md) before creating an issue or sending in a pull request.

## Code of Conduct

Please read our [Code of Conduct](code_of_conduct.md) before contributing or engaging in discussions.

## Security Vulnerabilities

If you discover a security vulnerability within Laravel.io, please send an email immediately to Dries Vints at [dries.vints@gmail.com](mailto:dries.vints@gmail.com). **Do not create an issue for the vulnerability.**

## License

The MIT License. Please see [the license file](license.txt) for more information.
