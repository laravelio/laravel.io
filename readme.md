# Laravel.io Community Portal

<img src="https://travis-ci.org/laravelio/laravel.io.svg?branch=master" alt="Build Status">
[![Code Climate](https://codeclimate.com/github/LaravelIO/laravel.io/badges/gpa.svg)](https://codeclimate.com/github/LaravelIO/laravel.io)
[![Test Coverage](https://codeclimate.com/github/LaravelIO/laravel.io/badges/coverage.svg)](https://codeclimate.com/github/LaravelIO/laravel.io/coverage)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](license.txt)
<img src="https://insight.sensiolabs.com/projects/50a7431f-66b0-4221-8837-7ccf1924031e/mini.png" alt="SensioLabsInsight">

This is the repository for the [Laravel.io](http://laravel.io) community portal. The code is entirely open source and licensed under [the MIT license](license.txt). Feel free to contribute to the portal by sending in a pull request.

## Table of Contents

- [Requirements](#requirements)
- [Installation](#installation)
- [Maintainers](#maintainers)
- [Contributing](#contributing)
- [Security Vulnerabilities](#security-vulnerabilities)
- [License](#license)

## Requirements

Please make sure you install the following tools before starting with the install procedure.

- [VirtualBox](https://www.virtualbox.org/)
- [Vagrant](https://www.vagrantup.com/)

## Installation

> Note that you're free to adjust the `~/Sites/laravelio` location to any new directory you want on your machine.

1. Clone this repository: `git clone git@github.com:laravelio/laravel-io.git ~/Sites/laravelio`
2. Add the `Homestead.yaml` file from below to the root of your project
3. Run `vagrant up`
4. SSH into your Vagrant box, go to `/home/vagrant/laravelio` and run the following commands:
    1. `composer install`
    2. `php artisan migrate --seed --env=local`
    3. `npm install && gulp`
5. Add `192.168.10.10 lio.loc` to your computer's `/etc/hosts` file

```yaml
ip: "192.168.10.10"
memory: 4096
cpus: 1
hostname: laravelio
name: laravelio
provider: virtualbox
mariadb: true

authorize: ~/.ssh/id_rsa.pub

keys:
    - ~/.ssh/id_rsa

folders:
    - map: "~/Sites/laravelio"
      to: "/home/vagrant/laravelio"

sites:
    - map: lio.loc
      to: "/home/vagrant/laravelio/public"

databases:
    - laravelio
```

You can now visit the app in your browser by visiting [http://lio.loc/](http://lio.loc).

## Maintainers

The Laravel.io portal is currently maintained by [Dries Vints](https://github.com/driesvints). If you have any questions please don't hesitate to contact us through the support widget on the [Laravel.io](http://laravel.io/) website.

## Contributing

Please see [the contributing guide](contributing.md) for details.

## Security Vulnerabilities

If you discover a security vulnerability within Laravel.io, please send an email immediately to Dries Vints at [dries.vints@gmail.com](mailto:dries.vints@gmail.com). **Do not create an issue for the vulnerability.**

## License

The MIT License. Please see [the license file](license.txt) for more information.
